<template>
  <div>
    <a-upload
      :file-list="fileList"
      :before-upload="beforeUpload"
      @remove="handleRemove"
      :disabled="uploading"
    >
      <a-button>
        <upload-outlined />
        Select File
      </a-button>
    </a-upload>
    <a-button
      type="primary"
      @click="handleUpload"
      :disabled="fileList.length === 0 || uploading"
      :loading="uploading"
      style="margin-top: 16px"
    >
      {{ uploading ? 'Uploading' : 'Start Upload' }}
    </a-button>
    <div v-if="uploadProgress > 0 && uploadProgress < 100">
      <a-progress :percent="uploadProgress" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { UploadOutlined } from '@ant-design/icons-vue';
import { message } from 'ant-design-vue';
import axios from 'axios';
import SparkMD5 from 'spark-md5';

const fileList = ref([]);
const uploading = ref(false);
const uploadProgress = ref(0);

const beforeUpload = (file) => {
  fileList.value = [file];
  return false; // Prevent auto uploading
};

const handleRemove = () => {
  fileList.value = [];
  uploadProgress.value = 0;
};

const handleUpload = async () => {
  if (fileList.value.length === 0) {
    message.error('Please select a file to upload.');
    return;
  }

  uploading.value = true;
  uploadProgress.value = 0;

  const file = fileList.value[0];
  const chunkSize = 5 * 1024 * 1024; // 5MB
  const totalChunks = Math.ceil(file.size / chunkSize);
  const fileId = await calculateFileHash(file);
  const fileName = file.name;

  for (let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex++) {
    const start = chunkIndex * chunkSize;
    const end = Math.min(start + chunkSize, file.size);
    const chunk = file.slice(start, end);

    const formData = new FormData();
    formData.append('file', chunk);
    formData.append('chunkIndex', chunkIndex);
    formData.append('totalChunks', totalChunks);
    formData.append('fileId', fileId);
    formData.append('fileName', fileName);

    try {
      const response = await axios.post('/upload', formData, {
        onUploadProgress: (progressEvent) => {
          const percentCompleted = Math.round(((chunkIndex * chunkSize) + progressEvent.loaded) * 100 / file.size);
          uploadProgress.value = percentCompleted;
        },
      });

      if (response.data.code === 0 && response.data.data.file_path) {
        // File merged
        uploadProgress.value = 100;
        message.success(`File uploaded successfully: ${response.data.data.file_path}`);
        break; // Exit loop after merge
      }

    } catch (error) {
      message.error('Upload failed.');
      uploading.value = false;
      return;
    }
  }

  uploading.value = false;
};

const calculateFileHash = (file) => {
  return new Promise((resolve, reject) => {
    const blobSlice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice;
    const chunkSize = 2097152; // Read in chunks of 2MB
    const chunks = Math.ceil(file.size / chunkSize);
    let currentChunk = 0;
    const spark = new SparkMD5.ArrayBuffer();
    const fileReader = new FileReader();

    fileReader.onload = (e) => {
      spark.append(e.target.result);
      currentChunk++;

      if (currentChunk < chunks) {
        loadNext();
      } else {
        resolve(spark.end());
      }
    };

    fileReader.onerror = (e) => {
      reject(e);
    };

    function loadNext() {
      const start = currentChunk * chunkSize;
      const end = ((start + chunkSize) >= file.size) ? file.size : start + chunkSize;
      fileReader.readAsArrayBuffer(blobSlice.call(file, start, end));
    }

    loadNext();
  });
};
</script>