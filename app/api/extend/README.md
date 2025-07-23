# 文档处理器类

本目录包含两个文档处理器类，用于处理PDF和Word文档的转换、合并和页数获取等功能。

## 类说明

### PdfProcessor

`PdfProcessor` 类提供了PDF文档的处理功能，包括：

- 生成预览图：将PDF文档转换为图片，支持指定页码范围、分辨率、输出格式和质量
- 获取页数：获取PDF文档的总页数
- 合并PDF：将多个PDF文件合并为一个PDF文件

### WordProcessor

`WordProcessor` 类提供了Word文档的处理功能，包括：

- 生成预览图：将Word文档转换为图片，支持指定页码范围、分辨率、输出格式和质量
- 获取页数：获取Word文档的总页数
- 合并Word：将多个Word文件合并为一个文档，支持输出为DOCX或PDF格式

## 使用方法

### 实例化

```php
// 实例化PDF处理器
$pdfProcessor = new PdfProcessor();

// 实例化Word处理器
$wordProcessor = new WordProcessor();
```

### 生成预览图

```php
// 生成PDF预览图
$pdfImages = $pdfProcessor->generatePreviewImages(
    '/path/to/document.pdf',  // PDF文件路径
    '1-3,5',                  // 页码范围，如 '1-3,5' 或 'all'
    150,                      // 分辨率（DPI）
    'jpg',                    // 输出格式（jpg 或 png）
    90                        // 图片质量（1-100）
);

// 生成Word预览图
$wordImages = $wordProcessor->generatePreviewImages(
    '/path/to/document.docx', // Word文件路径
    '1-3,5',                  // 页码范围，如 '1-3,5' 或 'all'
    150,                      // 分辨率（DPI）
    'jpg',                    // 输出格式（jpg 或 png）
    90                        // 图片质量（1-100）
);
```

### 获取页数

```php
// 获取PDF页数
$pdfPageCount = $pdfProcessor->getPageCount('/path/to/document.pdf');

// 获取Word页数
$wordPageCount = $wordProcessor->getPageCount('/path/to/document.docx');
```

### 合并文档

```php
// 合并PDF文件
$mergedPdfPath = $pdfProcessor->mergePdfFiles(
    ['/path/to/file1.pdf', '/path/to/file2.pdf'], // PDF文件路径数组
    '/path/to/output.pdf'                         // 输出文件路径（可选）
);

// 合并Word文件
$mergedWordPath = $wordProcessor->mergeWordFiles(
    ['/path/to/file1.docx', '/path/to/file2.docx'], // Word文件路径数组
    '/path/to/output.docx',                         // 输出文件路径（可选）
    'docx',                                         // 输出格式（docx 或 pdf）
    true,                                           // 是否使用PhpWord合并
    false                                           // 是否使用临时文件方式合并
);
```

## 测试页面

项目包含一个测试页面，用于测试文档处理器的功能：

```
http://your-domain/document-processor-test.html
```

该页面提供了以下功能：

1. 文档转图片：上传PDF或Word文档，将其转换为图片
2. 获取页数：上传PDF或Word文档，获取其页数
3. 合并PDF：上传多个PDF文件，将其合并为一个PDF文件
4. 合并Word：上传多个Word文件，将其合并为一个文档
5. 系统信息：获取系统信息，包括可用的转换工具和库

## 依赖项

这些处理器类依赖于以下工具和库：

### PDF处理

- Imagick PHP扩展
- Ghostscript
- Poppler-utils（pdfinfo, pdftoppm）
- pdftk

### Word处理

- PhpWord库
- LibreOffice或OpenOffice
- Ghostscript（用于PDF转换）

## 注意事项

1. 这些处理器类会尝试使用多种方法来处理文档，如果一种方法失败，会自动尝试下一种方法
2. 处理大型文档可能需要较长时间，请确保PHP的执行时间限制足够长
3. 临时文件会自动清理，但在处理过程中可能会占用较多磁盘空间