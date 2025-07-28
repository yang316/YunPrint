/*
 Navicat Premium Dump SQL

 Source Server         : docker
 Source Server Type    : MySQL
 Source Server Version : 80034 (8.0.34)
 Source Host           : 127.0.0.1:3306
 Source Schema         : YunPrint

 Target Server Type    : MySQL
 Target Server Version : 80034 (8.0.34)
 File Encoding         : 65001

 Date: 28/07/2025 18:06:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sa_article
-- ----------------------------
DROP TABLE IF EXISTS `sa_article`;
CREATE TABLE `sa_article`  (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '编号',
  `category_id` int NOT NULL COMMENT '分类id',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文章标题',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文章作者',
  `image` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章图片',
  `describe` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文章简介',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文章内容',
  `views` int NULL DEFAULT 0 COMMENT '浏览次数',
  `sort` int UNSIGNED NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint UNSIGNED NULL DEFAULT 1 COMMENT '状态',
  `is_link` tinyint(1) NULL DEFAULT 2 COMMENT '是否外链',
  `link_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '链接地址',
  `is_hot` tinyint UNSIGNED NULL DEFAULT 2 COMMENT '是否热门',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_category_id`(`category_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '文章表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_article
-- ----------------------------
INSERT INTO `sa_article` VALUES (1, 4, '东欧72分独行侠4-1淘汰森林狼 东契奇西决MVP', '新浪体育', 'https://image.saithink.top/saiadmin/0d0efed68441cd12d993d30a767f6119.jpg', '北京时间5月31日，NBA西部决赛G5，独行侠124-103大胜森林狼，独行侠大比分4-1淘汰森林狼晋级总决赛，将在总决赛对阵凯尔特人。卢卡-东契奇当选西部决赛MVP', '<p><br></p>', 3, 100, 1, 2, '', 2, 1, 1, '2024-06-02 22:55:25', '2024-07-31 16:31:42', NULL);
INSERT INTO `sa_article` VALUES (2, 4, '爱德华兹29+10+9 森林狼险胜独行侠大比分1-3', '新浪体育', 'https://image.saithink.top/saiadmin/e5934011260c015721010baed74cbfaa.jpg', '北京时间5月29日，NBA季后赛西部决赛G4，森林狼105-100险胜独行侠，森林狼将大比分追至1-3。 森林狼（1-3）：爱德华兹29分10篮板9助攻、唐斯25分5篮板', '<p><br></p>', 0, 100, 1, 2, '', 2, 1, 1, '2024-06-02 22:56:47', '2024-07-31 16:31:56', NULL);
INSERT INTO `sa_article` VALUES (3, 5, '阿森纳理疗师里斯将前往曼联担任首席理疗师', '新浪体育', 'https://image.saithink.top/saiadmin/0c64a22cef1ad90d650056a6051da8c6.jpg', 'The Athletic报道，阿森纳理疗师乔丹-里斯即将加盟曼联，成为红魔的首席理疗师。曼联首席理疗师罗宾-萨德勒已于今年一月离开俱乐部', '<p><br></p>', 0, 100, 1, 2, '', 2, 1, 1, '2024-06-02 22:58:41', '2024-07-31 16:32:05', NULL);
INSERT INTO `sa_article` VALUES (4, 6, '半场-马莱莱斩获赛季第6球 申花1-0领先深圳新鹏城', '新浪体育', 'https://image.saithink.top/saiadmin/ce0c150d2ef32cf9e9c9d4332204446d.jpg', '5月26日晚上18：00，中超第14轮，深圳新鹏城主场迎战上海申花，上半场马莱莱补射斩获赛季第6球，半场战罢，申花暂1-0新鹏城', '<p> &nbsp; &nbsp; &nbsp; &nbsp;5月26日晚上18：00，中超第14轮，深圳新鹏城主场迎战上海申花，上半场马莱莱补射斩获赛季第6球，半场战罢，申花暂1-0新鹏城。</p><p><br></p>', 0, 100, 1, 2, '', 2, 1, 1, '2024-06-02 22:59:41', '2024-07-31 16:31:32', NULL);
INSERT INTO `sa_article` VALUES (5, 7, '周也热巴带火猫塑女风 如何打造猫系女孩妆容', '新浪时尚', 'https://image.saithink.top/saiadmin/6596f10181d4f482dec009ac758fbf89.jpg', '最近，要问什么最火？不是女明星胜似女明星，说的就是汤姆猫的女朋友', '<p> &nbsp; &nbsp; &nbsp; &nbsp;最近，要问什么最火？不是女明星胜似女明星，说的就是汤姆猫的女朋友：</p><p><br></p><p style=\"text-align: center;\">　　《猫和老鼠》截图（豆瓣）</p><p>　　说是女朋友，不如说是汤姆的女神更为贴切。她身上有着娇俏、妩媚、精致的人类特质，又有着像猫咪一样的慵懒和傲娇，网红和明星都纷纷将她拟人化。</p><p><br></p><p style=\"text-align: center;\">　　《猫和老鼠》截图（豆瓣）</p><p>　　周也这波，在你心里是几分？</p><p><br></p><p><br></p><p>　　猫系女孩当然会具备像小猫一样的慵懒和傲娇，体现在面部特征上，大概率就是这样的类型：</p><p><br></p><p style=\"text-align: center;\">　　微博@喜欢傲娇迪</p><p>　　首先，面部和五官的排布占比中，五官的比重更大。同时，眼睛会是偏圆润的类型。</p><p><br></p><p>　　整体看上去面部的锐感是很微弱的，而钝感较强。比较明显的对比就是Jennie、宁艺卓这类长相与黄礼志是截然不同的两种风格：</p><p><br></p><p><br></p><p>　　在圆眼型的基础上，猫系女孩的眼睛是有上扬感的。面中饱满，鼻子占比大，下巴短而圆润，看上去十分可爱。</p><p><br></p><p style=\"text-align: center;\">　　微博@喜欢傲娇迪</p><p><br></p><p style=\"text-align: center;\">　　微博@妹妹你真吃藕</p><p>　　上面的特征听起来好像都不是什么特别的长相，怎么组合在一起就变成了危险又迷人的猫女了呢？</p><p>　　这大概要归功于钝感带来的眼缘。猫系长相中，面部软组织略厚是一个重要特点。这会给人一种可爱感和亲切感，看上去还会有一种慵懒和随意的气质。同时，这种面相在传统意义中，也代表着喜庆、福气和财富。因此，这也是长辈们特别钟爱的类型。</p><p><br></p><p>　　先来说说猫系女孩怎么妆发：</p><p>　　猫系女孩的妆容烦恼也源自于面部软组织的钝感。因为这种饱满，以及面部折叠度低的特点，特写时会有点显胖。</p><p>　　要想解决这个问题，我们可以把重点放在改善面部长宽比上。长宽比较小，又没有特别突出的面部棱角感，看上去会更衬托圆润感，还会突出没有起伏的“平”，因此我们可以通过侧面内推的修容和长发，去把露肤的脖子也拉进面部比例中：</p><p><br></p><p>　　第二，我们要强化面部的起伏，也就是画强调五官的妆容。</p><p>　　猫系女孩的钝感会导致很难塑造外轮廓，因此在这个部分只需要打造向内推的流畅感即可，把轮廓交给五官。通过眼窝、山根、眉骨的轮廓架起基调，弱化上半张脸的“平”感，再通过饱满的唇妆，强化轮廓的同时增加下庭存在感。</p><p><br></p><p>　　接下来，我们再说说猫系妆感要怎么塑造。</p><p>　　重点有三。</p><p>　　其一，是面部的小巧流畅感。</p><p>　　先找到自己面部最凹陷的一些部分——可以通过手机的手电筒，从下巴往上照，最阴影的地方就是需要调整的位置。三八线、嘴角这些部分要尤其注意，在底妆时就要用亮一色的遮瑕着重遮盖，再盖上散粉。在后续上妆时，避免使用大颗粒、强反光的彩妆产品，不需强调饱满度。使用弱反光、细颗粒及哑光的自然妆感产品，会给人一种原生皮光泽感，更能够凸显猫系的元气魅力。</p><p><br></p><p><br></p><p>　　其二，是眼妆的塑造。</p><p>　　重点是眼睑下至配合眼尾上扬走势，让眼睛呈现出慵懒和深邃的质感。</p><p><br></p><p>　　轮廓色扩大面积，强调色收缩在睫毛根部周围，让眼神更聚光，营造出猫咪圆眼大瞳孔状态下的可爱质感。</p><p><br></p><p><br></p><p>　　其三是腮红和唇妆带来的大面积氛围感。</p><p><br></p><p>　　精致圆润又饱满的唇妆是猫系妆感的重要特征。我们可以在这一步，利用口红颜色的遮盖度调整唇形和唇部对称情况，强调下庭比例，也会在视觉上优化面部五官排布：</p><p><br></p><p>　　同时，使用能够与唇色呼应的腮红色，以团式打法轻扫面中，提升面部平整度的同时，强化可爱氛围感：</p><p><br></p>', 2, 100, 1, 2, '', 2, 1, 1, '2024-06-02 23:01:17', '2024-07-31 16:31:25', NULL);
INSERT INTO `sa_article` VALUES (6, 8, '深度 | 明星穿高定亮相红毯，为何遭客户投诉？', '新浪时尚', 'https://image.saithink.top/saiadmin/2e22e75a309264293ff0a04be1457eac.jpg', '曾经神秘的高级定制正处于舆论漩涡。 国内高级定制客户lulu近日在社交媒体上发帖，控诉意大利奢侈品牌Giambattista Valli在未征求她意见的情况下.', '<p> &nbsp; &nbsp; &nbsp; &nbsp;曾经神秘的高级定制正处于舆论漩涡。</p><p>　　国内高级定制客户lulu近日在社交媒体上发帖，控诉意大利奢侈品牌Giambattista Valli在未征求她意见的情况下，将其已购买的一件高级定制作品的样衣，借予英国演员Anya Taylor-Joy以出席电影首映会，引发网友广泛讨论。</p><p>　　截至发稿，原帖的点赞数已超过1万，而相关讨论帖的平均热度也达上千。</p><p>　　事件焦点是一套来自Giambattista Valli 2024春夏高级定制系列中的立体玫瑰花朵连体衣。lulu称此前在今年年初的巴黎高级定制周中已支付该作品的定金，但目前已决定放弃20余万元的定金并选择退货。</p><p>　　在该名高级定制客户看来，Giambattista Valli过于商业化的做法违背了行业潜规则，也让她失去了收藏高级定制的意义，并称其是“没有底蕴的二线品牌”。</p><p>国内高级定制客户lulu控诉Giambattista Valli过于商业化的做法违背了行业潜规则</p><p>　　Giambattista Valli由意大利同名设计师于2005年成立，于2017年将少数股权出售给开云集团控股股东Pinault家族名下公司Artémis。去年9月，Giambattista Valli宣布上任仅三年的首席执行官Charlotte Werner离职，目前暂未任命继任者。</p><p>　　2011年，Giambattista Valli成为法国高级时装协会的正式成员，并发布其首个高级定制系列。凭借其标志性的梦幻色彩、纱质褶皱以及巨大裙摆，该品牌很快赢得包括蕾哈娜、杨幂、迪丽热巴等国内外明星的青睐，被称为红毯上的新一代“高定之王”。</p><p>　　从明星粉丝间近几年掀起的红毯高定攀比之风中不难看出，其希望从中获得背书的高级定制位于时装产业金字塔塔尖，这也就意味着高级定制拥有与普通奢侈品截然不同的运作逻辑。</p><p>　　作为精英的特供、权力的体现，高级定制无关乎季节性和功能性，也脱离了最基本的商业准则，它只需要展示极致的创意、繁复的工艺和令人咋舌的耗时。尽管高级定制并不是一门赚钱的生意，但它所营造的终极时装梦想养活了整个时尚产业。</p><p>　　某种程度上来说，相比于同属于一家时装屋的成衣系列，高级定制往往与高级珠宝或其他艺术收藏品有着更多相似之处，高昂的标价不仅涵盖作品本身的创意价值，还蕴藏着不可复制的唯一性。</p><p>Giambattista Valli被称为红毯上的新一代“高定之王”</p><p>　　在lulu本次以及此前的多条帖文中均曾提及，Valentino、Giorgio Armani Privé等传统时装屋的高级定制系列具有唯一性，即已经被客户购买的作品将不会以完全相同的外观再出现在其他场合。</p><p>　　如果品牌需要向明星借出该作品，往往会与客户进行沟通，并对其颜色、细节等进行部分改动，以示对高级定制买家的尊重。尽管这并不是明文规定，但却已经成为行业内众所周知的潜规则。</p><p>　　Giambattista Valli如今的做法无疑破坏了这一约定，而lulu自身的影响力更是让这一事件在社交媒体中被反复发酵，令该品牌陷入舆论危机。</p><p>　　不同于国内传统高级定制客户的低调，lulu早在多年前就凭借Valentino音符裙等高级定制作品，独特的收藏品味，以及与Giorgio Armani、Pierpaolo Piccioli等多位明星设计师的互动，而在社交媒体上拥有众多粉丝，其全平台的粉丝数目前已累计超过100万。去年，lulu还在上海开设了一个陈列其所有高级定制收藏的空间Maison Lulu。</p><p>图为lulu购买的Valentino高级定制作品，以及Lady Gaga所身着的改动版</p><p>　　有数据表明，全球高级定制客户仅两千人左右，这也就意味着任何一位客户都至关重要，更何况在舆论发酵后，Giambattista Valli将在中国损失相当大的市场份额，似乎已经成为事实。</p><p>　　尽管由于高级定制的特殊性，该事件几乎被公认为Giambattista Valli的工作失误，但在更广泛的奢侈品领域，明星与VIC客户之间的矛盾却愈演愈烈。</p><p>　　今年年初，LV代言人周冬雨在参加2024秋冬系列时装秀时，就因在合影环节的不配合举动而被VIC客户投诉，并引起社交媒体上广泛关注。据后者所述，品牌方在时装秀结束后安排了合影环节，但周冬雨却态度敷衍，令其感到不适。随后，另一位LV VIC客户也在社交媒体上发帖表示认同。</p><p>　　数据显示，相关微博话题的阅读量短时间内就已超6700万。</p><p>周冬雨出席LV 24秋冬女装秀却遭VIC客户投诉</p><p>　　明星与VIC客户之间的矛盾中，隐藏着话语权和资源的争夺。</p><p>　　在明星效应尚未被大范围应用的时代，VIC客户自然占据上风。</p><p>　　2001年，Chanel为打开年轻市场曾任命歌手李玟为代言人，但有消息指出，该任命被香港VIC客户强烈抵制，导致品牌最终撤掉了代言人。往后的十几年，奢侈品牌在中国市场仍然相对保守，极度爱惜羽毛，对品牌形象一丝不苟，VIC客户的稳定也让品牌鲜少启用明星扩大市场影响力。</p><p>　　然而随着中国社交媒体的迅速发展以及粉丝经济的兴起，流量明星能为品牌带来的短期价值陡然上升。在行业持续低迷的情况下，不少奢侈品牌开始尝试与他们合作。</p><p>　　2017年，Angelababy成为Dior中国区首位品牌大使，并建立了庞大的明星矩阵。借助粉丝经济的红利，在高密度的市场营销活动配合之下，Dior时装秀在社交媒体上的讨论热度逐季攀升，促进品牌的市场影响力在几年内获得指数级增长。</p><p>　　巨大的增幅令奢侈品行业在此后的约五年间激进地押注明星策略，激烈的市场竞争彻底改变了奢侈品牌的心态，使他们在高收益面前跃跃欲试。</p><p>　　LVMH首席财务官Jean-Jacques Guiony曾在当时坦言，“我们并不担心过度曝光，真正的风险是势头不够以致于不能在市场竞争中冲在前面。”</p><p>　　据CBNData与星数的《2020年上半年明星带货》报告显示，即使在疫情期间，仅半年明星引导消费金额就同比增长了52.3%。在奢侈品牌的社交账号上，与明星相关的推文的转评赞通常是常规推文几千倍甚至几万倍。</p><p>奢侈品行业在2017年后激进地押注明星策略</p><p>　　在此期间，即使面临边际效应递减，任命流量明星风险过高等挑战，奢侈品牌依然将其视为最有效的传播媒介。</p><p>　　如果只是有限的回报，奢侈品牌显然不会冒如此大的风险，这背后的关键在于明星在扩大市场影响力以及刺激市场消费的维度上，有着不可替代的作用，而这对于正处于扩张期的奢侈品牌而言至关重要。</p><p>　　笼络中产阶层消费者，是奢侈品牌过去几年的核心策略，他们为后者提供了巨大的市场增量，也为集团不断上涨的股价提供动力。代言人则正是吸引这部分群体最直接的手段之一，明星对奢侈品牌的重要性自然也水涨船高。</p><p>　　然而当经济持续承压，中产阶层消费者购买力因此显著下滑时，明星代言人所能完成的转化也随之降低，再叠加消费者对愈发频繁和同质化的代言人策略的疲劳，品牌增长动力链出现断裂。</p><p>　　奢侈品牌于是逐步意识到核心客群的重要性，并将销售重心重新从中产阶层向高净值人群偏移。面临不确定性增大的市场环境，他们往往拥有更好的抗风险能力。</p><p>　　贝恩报告曾经指出，仅2%的VIC客户贡献了全球奢侈品销售额的40%，而2009年仅为35%，中国市场的VIC集中度超过了全球平均水平。摩根士丹利的分析称在中国一些主要高端购物中心，不到1%的顾客就可以贡献高达40%的销售额。因此在继续稳固非核心消费者规模的同时，奢侈品牌正将如何继续提升VIC核心消费者忠诚度摆在战略地位上。</p><p>　　自2022年起，LV、Chanel和Dior等奢侈品牌接连在北京、上海、广州、深圳以及成都等多个主要奢侈品消费城市，开设VIC沙龙空间，将手伸至这些高净值人群口袋的更深处。上周，LV在其广州太古汇精品店的二层开设了全新沙龙空间，陈列男女成衣、晚礼服、皮具、高级珠宝腕表以及硬箱等产品。</p><p>　　在这一背景下，VIC客户在品牌的话语权也随之被放大，其与明星之间微妙的比较心理或许是二者矛盾的根源。</p><p>　　本质上，明星对应着中产阶层消费者，而奢侈品牌过去十多年间所做的就是在中产阶层和VIC客户之间建立动态平衡。</p><p>　　对于已经驶出高速发展期的奢侈品牌而言，如今的业绩增长更多依靠客户关系管理，通过提升VIC客户的忠诚度完成销售转化，而非过去五年间依靠明星代言人，扩大市场影响力以吸引潜在消费者购买的驱动模式。</p><p><br></p><p>　　这也是奢侈品牌如今在明星策略上逐渐保守的原因，相较于高风险高收益的流量偶像，它们或许更青睐作品口碑俱佳的成熟艺人，这些明星拥有经过时间检验的影响力，并在多个圈层乃至于全球市场拥有影响力。</p><p>　　2022年11月，Balenciaga任命奥斯卡影后杨紫琼为品牌大使。去年12月，周杰伦被Dior任命为全球品牌大使，成为首个拥有该头衔的中国明星，三个月后其成为箱包品牌Rimowa首位华人全球品牌代言人。</p><p>　　在奢侈品牌纷纷将天平向VIC客户倾斜时，一直以来在明星策略上颇为激进的Prada集团又因其代言人而深陷舆论危机。</p><p>　　Miu Miu品牌代言人张元英的所属韩国女子团体ive，此前就因其《HEYA》MV中的文化挪用现象而引发热议，近日又被指新歌《Accendio》MV中一镜头或涉及辱华。近日，有大量中国网友在品牌官方Instagram账号发言敦促品牌与明星解约，Miu Miu目前对此尚未置评。</p><p>　　面对明星背后的消费者，和品牌直面的消费者，奢侈品牌正在谨慎调节手中的天平。</p>', 2, 100, 1, 2, '', 2, 1, 1, '2024-06-02 23:02:40', '2024-07-31 16:31:19', NULL);
INSERT INTO `sa_article` VALUES (7, 9, '荣耀正在筹备一大波新品 两款折叠屏＋X60＋ GT新机', '新浪科技', 'https://image.saithink.top/saiadmin/f6b9600dbe57c1e0344a01d75f16afc8.jpg', '荣耀正在筹备一大波新品 两款折叠屏＋X60＋ GT新机 【CNMO科技消息】5月31日，CNMO注意到，据知名爆料人士“数码闲聊站”透露，荣耀方面似乎正在筹备大量新品', '<p>荣耀正在筹备一大波新品 两款折叠屏＋X60＋ GT新机</p><p>　　【CNMO科技消息】5月31日，CNMO注意到，据知名爆料人士“数码闲聊站”透露，荣耀方面似乎正在筹备大量新品，接下来的6、7、8月基本都有活动。</p><p><br></p><p>　　据悉，荣耀有两款折叠屏手机正在筹备，分别为超大尺寸外屏的小折叠屏手机和超轻薄的大折叠屏手机。据悉，荣耀小折叠屏新机将会在下个月跟大家见面，新机依旧会沿用Magic系列命名，采用目前行业最大电池和最大外屏的小折叠屏手机，可折叠次数也比较猛，并且新机也会提供联名版本。荣耀的大折叠屏手机也同样值得期待，预计该机将在屏幕、续航、影像、厚度、重量等多方面进行改进。</p><p><br></p><p>　　近日，不久前荣耀X50的国内销量已经突破了1000万部，堪称“入门销量王”。而据爆料，荣耀X60将会采用高端设计语言，内置超大容量电池，抗摔能力进一步提升，同时普及等深四曲面屏幕。荣耀X60或许将会成为一款“披着旗舰手机皮的千元机”，销量有望延续前代产品辉煌。</p><p>　　荣耀GT系列新机暂未有消息流传，参考目前的荣耀GT产品，新机应该是一款侧重性能的高性价比机型。</p><p>　　此外，据透露，荣耀还有多款搭载高通骁龙8 Gen 3移动平台和高通骁龙8s Gen 3移动平台的新品正在筹备。</p>', 5, 100, 1, 2, '', 2, 1, 1, '2024-06-02 23:04:23', '2024-07-31 16:31:10', NULL);

-- ----------------------------
-- Table structure for sa_article_banner
-- ----------------------------
DROP TABLE IF EXISTS `sa_article_banner`;
CREATE TABLE `sa_article_banner`  (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '编号',
  `banner_type` int NULL DEFAULT NULL COMMENT '类型',
  `image` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '图片地址',
  `is_href` tinyint(1) NULL DEFAULT 1 COMMENT '是否链接',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '链接地址',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '标题',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `sort` int NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '描述',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '文章轮播图' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_article_banner
-- ----------------------------
INSERT INTO `sa_article_banner` VALUES (1, 1, 'https://image.saithink.top/saiadmin/d758c454ef03c49ac7185c7290b020e2.jpg', 1, '/app/saicms/index/article?id=5', '周也热巴带火猫塑女风 如何打造猫系女孩妆容', 1, 0, NULL, 1, 1, '2024-06-02 23:06:37', '2024-07-31 16:24:15', NULL);
INSERT INTO `sa_article_banner` VALUES (2, 1, 'https://image.saithink.top/saiadmin/eb5cc8b9ad1c3e562bae8af25ce630eb.jpg', 1, '/app/saicms/index/article?id=6', '深度 | 明星穿高定亮相红毯，为何遭客户投诉？', 1, 0, NULL, 1, 1, '2024-06-02 23:06:49', '2024-07-31 16:24:23', NULL);
INSERT INTO `sa_article_banner` VALUES (3, 1, 'https://image.saithink.top/saiadmin/995de531bb0c5fd2dac8e8d9e0421344.jpg', 1, '/app/saicms/index/article?id=7', '荣耀正在筹备一大波新品 两款折叠屏＋X60＋ GT新机', 1, 0, NULL, 1, 1, '2024-06-02 23:06:56', '2024-07-31 16:24:34', NULL);

-- ----------------------------
-- Table structure for sa_article_category
-- ----------------------------
DROP TABLE IF EXISTS `sa_article_category`;
CREATE TABLE `sa_article_category`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `parent_id` int NOT NULL DEFAULT 0 COMMENT '父级ID',
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '分类标题',
  `describe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '分类简介',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '分类图片',
  `sort` int UNSIGNED NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint UNSIGNED NULL DEFAULT 1 COMMENT '状态',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '文章分类表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_article_category
-- ----------------------------
INSERT INTO `sa_article_category` VALUES (1, 0, '体育', '', NULL, 100, 1, 1, 1, '2024-06-02 22:50:51', '2024-07-31 17:24:49', NULL);
INSERT INTO `sa_article_category` VALUES (2, 0, '娱乐', '', NULL, 100, 1, 1, 1, '2024-06-02 22:50:56', '2024-07-20 23:01:30', NULL);
INSERT INTO `sa_article_category` VALUES (3, 0, '科技', '', NULL, 100, 1, 1, 1, '2024-06-02 22:51:01', '2024-07-20 19:49:47', NULL);
INSERT INTO `sa_article_category` VALUES (4, 1, 'NBA', NULL, NULL, 100, 1, 1, 1, '2024-06-02 22:51:16', '2024-06-02 22:51:16', NULL);
INSERT INTO `sa_article_category` VALUES (5, 1, '英超', NULL, NULL, 100, 1, 1, 1, '2024-06-02 22:51:39', '2024-06-02 22:51:39', NULL);
INSERT INTO `sa_article_category` VALUES (6, 1, '中超', NULL, NULL, 100, 1, 1, 1, '2024-06-02 22:51:49', '2024-06-02 22:51:49', NULL);
INSERT INTO `sa_article_category` VALUES (7, 2, '时尚', NULL, NULL, 100, 1, 1, 1, '2024-06-02 22:52:03', '2024-06-02 22:52:03', NULL);
INSERT INTO `sa_article_category` VALUES (8, 2, '女性', NULL, NULL, 100, 1, 1, 1, '2024-06-02 22:52:12', '2024-06-02 22:52:12', NULL);
INSERT INTO `sa_article_category` VALUES (9, 3, '手机', NULL, NULL, 100, 1, 1, 1, '2024-06-02 22:52:37', '2024-06-02 22:52:37', NULL);
INSERT INTO `sa_article_category` VALUES (10, 3, '生活', NULL, NULL, 100, 1, 1, 1, '2024-06-08 13:37:51', '2024-06-08 13:37:51', NULL);

-- ----------------------------
-- Table structure for sa_coupon_template
-- ----------------------------
DROP TABLE IF EXISTS `sa_coupon_template`;
CREATE TABLE `sa_coupon_template`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '模板ID',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '优惠券标题',
  `type` tinyint UNSIGNED NOT NULL DEFAULT 1 COMMENT '优惠券类型(1:满减券)',
  `amount` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '优惠金额',
  `min_amount` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '满减门槛金额',
  `valid_days` int UNSIGNED NOT NULL COMMENT '有效天数',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` tinyint UNSIGNED NULL DEFAULT 0 COMMENT '状态:1=启用,0=关闭',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = '优惠券模板表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_coupon_template
-- ----------------------------
INSERT INTO `sa_coupon_template` VALUES (1, '测试', 1, 5.00, 20.00, 7, '2025-07-28 14:54:49', '2025-07-28 16:31:29', 1);

-- ----------------------------
-- Table structure for sa_order
-- ----------------------------
DROP TABLE IF EXISTS `sa_order`;
CREATE TABLE `sa_order`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL COMMENT '用户ID',
  `order_sn` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单号',
  `totalPrice` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '总价',
  `couponPrice` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '优惠券价格',
  `postage` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '邮费',
  `create_time` datetime NULL DEFAULT NULL COMMENT '下单时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '更新时间',
  `payType` enum('wechat') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'wechat' COMMENT '支付方式',
  `status` tinyint UNSIGNED NULL DEFAULT 0 COMMENT '订单状态:0=未支付,1=待收货,2=已完成',
  `payStatus` tinyint UNSIGNED NULL DEFAULT 0 COMMENT '支付状态:0=未支付,1=已支付',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `idx_id`(`id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_order
-- ----------------------------
INSERT INTO `sa_order` VALUES (1, 1, 'YunPrint20250725173628120212', 14.00, 0.00, 0.00, '2025-07-25 17:36:28', '2025-07-25 17:36:28', NULL, 0, 0);
INSERT INTO `sa_order` VALUES (2, 1, 'YunPrint20250725173821862335', 14.00, 0.00, 0.00, '2025-07-25 17:38:21', '2025-07-25 17:38:21', NULL, 0, 0);
INSERT INTO `sa_order` VALUES (3, 1, 'YunPrint20250725173846277086', 14.00, 0.00, 0.00, '2025-07-25 17:38:46', '2025-07-25 17:38:46', NULL, 0, 0);
INSERT INTO `sa_order` VALUES (4, 1, 'YunPrint20250725173945408594', 14.00, 0.00, 0.00, '2025-07-25 17:39:45', '2025-07-25 17:39:45', NULL, 0, 0);
INSERT INTO `sa_order` VALUES (5, 1, 'YunPrint20250725174129269388', 14.00, 0.00, 0.00, '2025-07-25 17:41:29', '2025-07-25 17:41:29', NULL, 0, 0);

-- ----------------------------
-- Table structure for sa_order_items
-- ----------------------------
DROP TABLE IF EXISTS `sa_order_items`;
CREATE TABLE `sa_order_items`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int UNSIGNED NOT NULL COMMENT '订单ID',
  `fileName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文件名',
  `paperPrice` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '纸张价格',
  `totalPrice` decimal(10, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '总价',
  `totalPage` int UNSIGNED NOT NULL COMMENT '文件页数',
  `copies` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '份数',
  `options` json NULL COMMENT '规格',
  `atta_id` int UNSIGNED NULL DEFAULT NULL COMMENT '附件ID',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '订单详情表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_order_items
-- ----------------------------
INSERT INTO `sa_order_items` VALUES (1, 1, '合作后外部群标准话术_1753422065862_.pdf', 1.00, 7.00, 7, 1, NULL, 147, '2025-07-25 17:36:28', '2025-07-25 17:36:28');
INSERT INTO `sa_order_items` VALUES (2, 1, '合作后外部群标准话术_1753425041216_.pdf', 1.00, 7.00, 7, 1, NULL, 148, '2025-07-25 17:36:28', '2025-07-25 17:36:28');
INSERT INTO `sa_order_items` VALUES (3, 2, '合作后外部群标准话术_1753422065862_.pdf', 1.00, 7.00, 7, 1, NULL, 147, '2025-07-25 17:38:21', '2025-07-25 17:38:21');
INSERT INTO `sa_order_items` VALUES (4, 2, '合作后外部群标准话术_1753425041216_.pdf', 1.00, 7.00, 7, 1, NULL, 148, '2025-07-25 17:38:21', '2025-07-25 17:38:21');
INSERT INTO `sa_order_items` VALUES (5, 3, '合作后外部群标准话术_1753422065862_.pdf', 1.00, 7.00, 7, 1, NULL, 147, '2025-07-25 17:38:46', '2025-07-25 17:38:46');
INSERT INTO `sa_order_items` VALUES (6, 3, '合作后外部群标准话术_1753425041216_.pdf', 1.00, 7.00, 7, 1, NULL, 148, '2025-07-25 17:38:46', '2025-07-25 17:38:46');
INSERT INTO `sa_order_items` VALUES (7, 4, '合作后外部群标准话术_1753422065862_.pdf', 1.00, 7.00, 7, 1, NULL, 147, '2025-07-25 17:39:45', '2025-07-25 17:39:45');
INSERT INTO `sa_order_items` VALUES (8, 4, '合作后外部群标准话术_1753425041216_.pdf', 1.00, 7.00, 7, 1, NULL, 148, '2025-07-25 17:39:45', '2025-07-25 17:39:45');
INSERT INTO `sa_order_items` VALUES (9, 5, '合作后外部群标准话术_1753422065862_.pdf', 1.00, 7.00, 7, 1, '[{\"id\": 1, \"name\": \"A4\", \"type\": \"paperSize\", \"price\": \"1.00\", \"value\": \"A4\"}, {\"id\": 6, \"name\": \"黑白\", \"type\": \"color\", \"price\": \"0.00\", \"value\": \"black_white\"}, {\"id\": 9, \"name\": \"单面\", \"type\": \"side\", \"price\": \"0.00\", \"value\": \"single\"}, {\"id\": 11, \"name\": \"普通纸\", \"type\": \"paperType\", \"price\": \"0.00\", \"value\": \"regular\"}, {\"id\": 12, \"name\": \"70g\", \"type\": \"paperWeight\", \"price\": \"0.00\", \"value\": \"70\"}, {\"id\": 18, \"name\": \"不装订\", \"type\": \"binding\", \"price\": \"0.00\", \"value\": \"none\"}, {\"id\": 19, \"name\": \"不缩印\", \"type\": \"multiPage\", \"price\": \"0.00\", \"value\": \"1\"}, {\"id\": 21, \"name\": \"皮纹纸\", \"type\": \"coverType\", \"price\": \"0.00\", \"value\": \"leathe\"}, {\"id\": 22, \"name\": \"深蓝\", \"type\": \"coverColor\", \"price\": \"0.00\", \"value\": \"darkBlue\"}, {\"id\": 23, \"name\": \"纯色封面\", \"type\": \"coverContent\", \"price\": \"0.00\", \"value\": \"plain\"}]', 147, '2025-07-25 17:41:29', '2025-07-25 17:41:29');
INSERT INTO `sa_order_items` VALUES (10, 5, '合作后外部群标准话术_1753425041216_.pdf', 1.00, 7.00, 7, 1, '[{\"id\": 1, \"name\": \"A4\", \"type\": \"paperSize\", \"price\": \"1.00\", \"value\": \"A4\"}, {\"id\": 6, \"name\": \"黑白\", \"type\": \"color\", \"price\": \"0.00\", \"value\": \"black_white\"}, {\"id\": 9, \"name\": \"单面\", \"type\": \"side\", \"price\": \"0.00\", \"value\": \"single\"}, {\"id\": 11, \"name\": \"普通纸\", \"type\": \"paperType\", \"price\": \"0.00\", \"value\": \"regular\"}, {\"id\": 12, \"name\": \"70g\", \"type\": \"paperWeight\", \"price\": \"0.00\", \"value\": \"70\"}, {\"id\": 18, \"name\": \"不装订\", \"type\": \"binding\", \"price\": \"0.00\", \"value\": \"none\"}, {\"id\": 19, \"name\": \"不缩印\", \"type\": \"multiPage\", \"price\": \"0.00\", \"value\": \"1\"}, {\"id\": 21, \"name\": \"皮纹纸\", \"type\": \"coverType\", \"price\": \"0.00\", \"value\": \"leathe\"}, {\"id\": 22, \"name\": \"深蓝\", \"type\": \"coverColor\", \"price\": \"0.00\", \"value\": \"darkBlue\"}, {\"id\": 23, \"name\": \"纯色封面\", \"type\": \"coverContent\", \"price\": \"0.00\", \"value\": \"plain\"}]', 148, '2025-07-25 17:41:29', '2025-07-25 17:41:29');

-- ----------------------------
-- Table structure for sa_print_setting
-- ----------------------------
DROP TABLE IF EXISTS `sa_print_setting`;
CREATE TABLE `sa_print_setting`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '选项类型',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '选项名称',
  `value` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '选项值',
  `price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '价格',
  `sort` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `is_default` tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否默认',
  `status` tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '更新时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `max_pages` int UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_type`(`type` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = '打印设置表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_print_setting
-- ----------------------------
INSERT INTO `sa_print_setting` VALUES (1, 'paperSize', 'A4', 'A4', 0.00, 1, 1, 1, '2025-07-16 14:19:26', '2025-07-28 14:12:11', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (2, 'paperSize', 'A3', 'A3', 0.00, 2, 2, 1, '2025-07-16 14:19:26', '2025-07-28 11:42:16', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (3, 'paperSize', 'A5', 'A5', 0.00, 3, 2, 1, '2025-07-16 14:19:26', '2025-07-28 11:42:20', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (4, 'paperSize', 'B4', 'B4', 0.00, 4, 2, 1, '2025-07-16 14:19:26', '2025-07-28 11:42:24', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (5, 'paperSize', 'B5', 'B5', 0.00, 5, 2, 1, '2025-07-16 14:19:26', '2025-07-22 15:16:33', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (6, 'color', '黑白', 'black_white', 0.00, 1, 1, 1, '2025-07-16 14:19:26', '2025-07-18 11:57:07', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (7, 'color', '鲜艳彩色', 'vibrant_color', 2.00, 2, 2, 1, '2025-07-16 14:19:26', '2025-07-18 11:56:21', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (8, 'color', '激光彩色', 'laser_color', 3.00, 3, 2, 1, '2025-07-16 14:19:26', '2025-07-18 11:39:17', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (9, 'side', '单面', 'single', 0.00, 1, 1, 1, '2025-07-16 14:19:26', '2025-07-22 15:16:42', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (10, 'side', '双面', 'double', 1.00, 2, 2, 1, '2025-07-16 14:19:26', '2025-07-22 15:16:47', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (11, 'paperType', '普通纸', 'regular', 1.00, 1, 1, 1, '2025-07-16 14:19:26', '2025-07-28 14:12:47', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (12, 'paperWeight', '70g', '70', 0.00, 1, 1, 1, '2025-07-16 14:19:26', '2025-07-22 15:18:27', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (13, 'paperWeight', '80g', '80', 0.50, 2, 2, 1, '2025-07-16 14:19:26', '2025-07-22 15:18:33', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (14, 'binding', '骑马钉', 'saddle_stitch', 2.00, 1, 2, 1, '2025-07-16 14:19:26', '2025-07-28 13:57:04', NULL, 60);
INSERT INTO `sa_print_setting` VALUES (15, 'binding', '订书钉', 'staple', 1.00, 2, 2, 1, '2025-07-16 14:19:26', '2025-07-28 13:59:24', NULL, 200);
INSERT INTO `sa_print_setting` VALUES (16, 'binding', '皮纹纸胶装', 'textured_binding', 5.00, 3, 2, 1, '2025-07-16 14:19:26', '2025-07-28 13:58:52', NULL, 600);
INSERT INTO `sa_print_setting` VALUES (17, 'binding', '铁圈', 'wire_binding', 3.00, 4, 2, 1, '2025-07-16 14:19:26', '2025-07-28 13:58:31', NULL, 60);
INSERT INTO `sa_print_setting` VALUES (18, 'binding', '不装订', 'none', 0.00, 5, 1, 1, '2025-07-16 14:19:26', '2025-07-18 11:57:36', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (19, 'multiPage', '不缩印', '1', 0.00, 1, 1, 1, '2025-07-22 14:29:52', '2025-07-24 16:01:42', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (21, 'coverType', '皮纹纸', 'leathe', 1.00, 1, 1, 1, '2025-07-22 14:48:06', '2025-07-28 11:45:14', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (22, 'coverColor', '深蓝', 'darkBlue', 0.00, 1, 1, 1, '2025-07-22 14:49:33', '2025-07-22 15:18:55', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (23, 'coverContent', '纯色封面', 'plain', 0.00, 1, 1, 1, '2025-07-22 14:49:57', '2025-07-28 14:37:28', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (24, 'paperType', '护眼纸', 'protection', 2.00, 2, 2, 1, '2025-07-24 11:31:57', '2025-07-28 11:42:56', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (25, 'coverType', '铜版纸', 'coated', 2.00, 2, 2, 1, '2025-07-24 11:34:24', '2025-07-28 11:45:23', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (26, 'coverColor', '深绿', 'darkGreen', 0.00, 2, 2, 1, '2025-07-24 11:56:11', '2025-07-28 11:46:02', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (27, 'coverColor', '浅绿', 'lightGreen', 0.00, 3, 2, 1, '2025-07-24 11:56:33', '2025-07-28 11:46:24', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (28, 'coverColor', '大红', 'red', 0.00, 4, 2, 1, '2025-07-24 11:57:20', '2025-07-28 11:46:06', NULL, 1);
INSERT INTO `sa_print_setting` VALUES (29, 'coverColor', '白色', 'white', 0.00, 5, 2, 1, '2025-07-24 11:57:35', '2025-07-28 11:46:20', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (30, 'coverColor', '浅黄', 'lightYellow', 0.00, 6, 2, 1, '2025-07-24 11:57:47', '2025-07-28 11:46:11', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (31, 'coverColor', '浅蓝', 'lightBlue', 0.00, 7, 2, 1, '2025-07-24 11:58:16', '2025-07-28 11:46:16', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (32, 'coverContent', '文字封面', 'text', 0.00, 2, 2, 1, '2025-07-24 14:37:01', '2025-07-28 11:45:38', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (33, 'coverContent', '文件首页为封面', 'firstPage', 0.00, 3, 2, 1, '2025-07-24 14:37:41', '2025-07-28 11:45:41', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (34, 'coverContent', '上传封面', 'upload', 0.00, 4, 2, 1, '2025-07-24 14:38:11', '2025-07-28 11:45:45', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (35, 'multiPage', '二页合一', '2', 0.00, 2, 2, 1, '2025-07-24 16:02:21', '2025-07-24 16:03:45', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (36, 'multiPage', '三页合一', '3', 0.00, 3, 2, 1, '2025-07-24 16:02:36', '2025-07-24 16:02:36', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (37, 'multiPage', '四页合一', '4', 0.00, 4, 2, 1, '2025-07-24 16:02:53', '2025-07-24 16:02:53', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (38, 'multiPage', '六页合一', '6', 0.00, 5, 2, 1, '2025-07-24 16:03:09', '2025-07-24 16:03:09', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (39, 'multiPage', '九页合一', '9', 0.00, 6, 2, 1, '2025-07-24 16:03:36', '2025-07-24 16:03:36', NULL, 0);
INSERT INTO `sa_print_setting` VALUES (40, 'binding', '铜版纸胶装', 'steel', 5.00, 6, 2, 1, '2025-07-28 13:47:35', '2025-07-28 13:58:37', NULL, 600);

-- ----------------------------
-- Table structure for sa_sms
-- ----------------------------
DROP TABLE IF EXISTS `sa_sms`;
CREATE TABLE `sa_sms`  (
  `id` int NOT NULL,
  `mobile` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '手机号',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '验证码',
  `create_time` datetime NULL DEFAULT NULL COMMENT '发送时间',
  `expire_time` datetime NULL DEFAULT NULL COMMENT '过期时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '短信表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_sms
-- ----------------------------

-- ----------------------------
-- Table structure for sa_system_attachment
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_attachment`;
CREATE TABLE `sa_system_attachment`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `storage_mode` smallint NULL DEFAULT 1 COMMENT '存储模式 (1 本地 2 阿里云 3 七牛云 4 腾讯云)',
  `origin_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '原文件名',
  `object_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '新文件名',
  `hash` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文件hash',
  `mime_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '资源类型',
  `storage_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '存储目录',
  `suffix` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文件后缀',
  `size_byte` bigint NULL DEFAULT NULL COMMENT '字节数',
  `size_info` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文件大小',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'url地址',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `storage_path`(`storage_path` ASC) USING BTREE,
  INDEX `hash`(`hash` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '上传文件信息表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for sa_system_config
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_config`;
CREATE TABLE `sa_system_config`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `group_id` int NULL DEFAULT NULL COMMENT '组id',
  `key` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置键名',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '配置值',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '配置名称',
  `input_type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '数据输入类型',
  `config_select_data` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '配置选项数据',
  `sort` smallint UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建人',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新人',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`, `key`) USING BTREE,
  INDEX `group_id`(`group_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '参数配置信息表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_config
-- ----------------------------
INSERT INTO `sa_system_config` VALUES (1, 1, 'site_copyright', 'Copyright © 2024 saithink', '版权信息', 'textarea', NULL, 96, '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (2, 1, 'site_desc', '基于vue3 + webman 的极速开发框架', '网站描述', 'textarea', NULL, 97, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (3, 1, 'site_keywords', '后台管理系统', '网站关键字', 'input', NULL, 98, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (4, 1, 'site_name', 'SaiAdmin', '网站名称', 'input', NULL, 99, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (5, 1, 'site_record_number', '', '网站备案号', 'input', NULL, 95, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (6, 2, 'upload_allow_file', 'txt,doc,docx,xls,xlsx,ppt,pptx,rar,zip,7z,gz,pdf,wps,md', '文件类型', 'input', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (7, 2, 'upload_allow_image', 'jpg,jpeg,png,gif,svg,bmp', '图片类型', 'input', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (8, 2, 'upload_mode', '1', '上传模式', 'select', '[{\"label\":\"本地上传\",\"value\":\"1\"},{\"label\":\"阿里云OSS\",\"value\":\"2\"},{\"label\":\"七牛云\",\"value\":\"3\"},{\"label\":\"腾讯云COS\",\"value\":\"4\"},{\"label\":\"亚马逊S3\",\"value\":\"5\"}]', 99, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (10, 2, 'upload_size', '5242880', '上传大小', 'input', NULL, 88, '单位Byte,1MB=1024*1024Byte', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (11, 2, 'local_root', 'public/storage/', '本地存储路径', 'input', NULL, 0, '本地存储文件路径', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (12, 2, 'local_domain', 'http://127.0.0.1:8787', '本地存储域名', 'input', NULL, 0, 'http://127.0.0.1:8787', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (13, 2, 'local_uri', '/storage/', '本地访问路径', 'input', NULL, 0, '访问是通过domain + uri', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (14, 2, 'qiniu_accessKey', '', '七牛key', 'input', NULL, 0, '七牛云存储secretId', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (15, 2, 'qiniu_secretKey', '', '七牛secret', 'input', NULL, 0, '七牛云存储secretKey', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (16, 2, 'qiniu_bucket', '', '七牛bucket', 'input', NULL, 0, '七牛云存储bucket', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (17, 2, 'qiniu_dirname', '', '七牛dirname', 'input', NULL, 0, '七牛云存储dirname', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (18, 2, 'qiniu_domain', '', '七牛domain', 'input', NULL, 0, '七牛云存储domain', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (19, 2, 'cos_secretId', '', '腾讯Id', 'input', NULL, 0, '腾讯云存储secretId', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (20, 2, 'cos_secretKey', '', '腾讯key', 'input', NULL, 0, '腾讯云secretKey', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (21, 2, 'cos_bucket', '', '腾讯bucket', 'input', NULL, 0, '腾讯云存储bucket', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (22, 2, 'cos_dirname', '', '腾讯dirname', 'input', NULL, 0, '腾讯云存储dirname', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (23, 2, 'cos_domain', '', '腾讯domain', 'input', NULL, 0, '腾讯云存储domain', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (24, 2, 'cos_region', '', '腾讯region', 'input', NULL, 0, '腾讯云存储region', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (25, 2, 'oss_accessKeyId', '', '阿里Id', 'input', NULL, 0, '阿里云存储accessKeyId', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (26, 2, 'oss_accessKeySecret', '', '阿里Secret', 'input', NULL, 0, '阿里云存储accessKeySecret', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (27, 2, 'oss_bucket', '', '阿里bucket', 'input', NULL, 0, '阿里云存储bucket', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (28, 2, 'oss_dirname', '', '阿里dirname', 'input', NULL, 0, '阿里云存储dirname', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (29, 2, 'oss_domain', '', '阿里domain', 'input', NULL, 0, '阿里云存储domain', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (30, 2, 'oss_endpoint', '', '阿里endpoint', 'input', NULL, 0, '阿里云存储endpoint', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (31, 3, 'Host', 'smtp.qq.com', 'SMTP服务器', 'input', '', 100, '', NULL, NULL, NULL, '2025-04-17 17:10:04', NULL);
INSERT INTO `sa_system_config` VALUES (32, 3, 'Port', '465', 'SMTP端口', 'input', '', 100, '', NULL, NULL, NULL, '2025-04-17 17:10:04', NULL);
INSERT INTO `sa_system_config` VALUES (33, 3, 'Username', '', 'SMTP用户名', 'input', '', 100, '', NULL, NULL, NULL, '2025-04-17 17:10:04', NULL);
INSERT INTO `sa_system_config` VALUES (34, 3, 'Password', '', 'SMTP密码', 'input', '', 100, '', NULL, NULL, NULL, '2025-04-17 17:10:04', NULL);
INSERT INTO `sa_system_config` VALUES (35, 3, 'SMTPSecure', 'ssl', 'SMTP验证方式', 'radio', '[\r\n    {\"label\":\"ssl\",\"value\":\"ssl\"},\r\n    {\"label\":\"tsl\",\"value\":\"tsl\"}\r\n]', 100, '', NULL, NULL, NULL, '2025-04-17 17:10:04', NULL);
INSERT INTO `sa_system_config` VALUES (36, 3, 'From', '', '默认发件人', 'input', '', 100, '默认发件的邮箱地址', NULL, NULL, NULL, '2025-04-17 17:10:04', NULL);
INSERT INTO `sa_system_config` VALUES (37, 3, 'FromName', '', '默认发件名称', 'input', '', 100, '', NULL, NULL, NULL, '2025-04-17 17:10:04', NULL);
INSERT INTO `sa_system_config` VALUES (38, 3, 'CharSet', 'UTF-8', '编码', 'input', '', 100, '', NULL, NULL, NULL, '2025-04-17 17:10:04', NULL);
INSERT INTO `sa_system_config` VALUES (39, 3, 'SMTPDebug', '0', '调试模式', 'radio', '[\r\n    {\"label\":\"关闭\",\"value\":\"0\"},\r\n    {\"label\":\"client\",\"value\":\"1\"},\r\n    {\"label\":\"server\",\"value\":\"2\"}\r\n]', 100, '', NULL, NULL, NULL, '2025-04-17 17:10:04', NULL);
INSERT INTO `sa_system_config` VALUES (40, 2, 's3_key', '', 'key', 'input', '', 0, '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (41, 2, 's3_secret', '', 'secret', 'input', '', 0, '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (42, 2, 's3_bucket', '', 'bucket', 'input', '', 0, '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (43, 2, 's3_dirname', '', 'dirname', 'input', '', 0, '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (44, 2, 's3_domain', '', 'domain', 'input', '', 0, '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (45, 2, 's3_region', '', 'region', 'input', '', 0, '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (46, 2, 's3_version', '', 'version', 'input', '', 0, '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (47, 2, 's3_use_path_style_endpoint', '', 'path_style_endpoint', 'input', '', 0, '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (48, 2, 's3_endpoint', '', 'endpoint', 'input', '', 0, '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sa_system_config` VALUES (49, 2, 's3_acl', '', 'acl', 'input', '', 0, '', NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for sa_system_config_group
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_config_group`;
CREATE TABLE `sa_system_config_group`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典标示',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建人',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新人',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '参数配置分组表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_config_group
-- ----------------------------
INSERT INTO `sa_system_config_group` VALUES (1, '站点配置', 'site_config', '18', 1, 11, '2021-11-23 10:49:29', '2025-04-17 17:20:45', NULL);
INSERT INTO `sa_system_config_group` VALUES (2, '上传配置', 'upload_config', NULL, 1, 1, '2021-11-23 10:49:29', '2021-11-23 10:49:29', NULL);
INSERT INTO `sa_system_config_group` VALUES (3, '邮件服务', 'email_config', NULL, 1, 1, '2021-11-23 10:49:29', '2025-04-17 17:10:04', NULL);

-- ----------------------------
-- Table structure for sa_system_dept
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_dept`;
CREATE TABLE `sa_system_dept`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `parent_id` int UNSIGNED NULL DEFAULT NULL COMMENT '父ID',
  `level` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '组级集合',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '部门名称',
  `status` smallint NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `sort` smallint UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `parent_id`(`parent_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '部门信息表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_dept
-- ----------------------------
INSERT INTO `sa_system_dept` VALUES (1, 0, '0', '赛弟科技', 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `sa_system_dept` VALUES (2, 1, '0,1', '青岛分公司', 1, 1, NULL, 1, 2, '2023-10-24 12:00:00', '2025-04-28 15:31:12', NULL);
INSERT INTO `sa_system_dept` VALUES (3, 1, '0,1', '洛阳分公司', 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2025-04-10 17:45:22', NULL);
INSERT INTO `sa_system_dept` VALUES (4, 2, '0,1,2', '市场部门', 1, 1, NULL, 1, 2, '2023-10-24 12:00:00', '2025-04-28 15:38:29', NULL);
INSERT INTO `sa_system_dept` VALUES (5, 2, '0,1,2', '财务部门', 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `sa_system_dept` VALUES (6, 3, '0,1,3', '研发部门', 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `sa_system_dept` VALUES (7, 3, '0,1,3', '市场部门', 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2025-03-26 23:30:10', NULL);

-- ----------------------------
-- Table structure for sa_system_dept_leader
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_dept_leader`;
CREATE TABLE `sa_system_dept_leader`  (
  `leader_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `dept_id` int UNSIGNED NOT NULL COMMENT '部门主键',
  `user_id` int UNSIGNED NOT NULL COMMENT '角色主键',
  PRIMARY KEY (`leader_id`) USING BTREE,
  INDEX `idx_dept_id`(`dept_id` ASC) USING BTREE,
  INDEX `idx_user_id`(`user_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '部门领导关联表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_dept_leader
-- ----------------------------

-- ----------------------------
-- Table structure for sa_system_dict_data
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_dict_data`;
CREATE TABLE `sa_system_dict_data`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type_id` int UNSIGNED NULL DEFAULT NULL COMMENT '字典类型ID',
  `label` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典标签',
  `value` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典值',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典标示',
  `sort` smallint UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `status` smallint NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '颜色',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `type_id`(`type_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 60 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '字典数据表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_dict_data
-- ----------------------------
INSERT INTO `sa_system_dict_data` VALUES (2, 2, '本地存储', '1', 'upload_mode', 99, 1, NULL, 1, 2, '2021-06-27 13:33:43', '2025-04-28 21:23:38', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (3, 2, '阿里云OSS', '2', 'upload_mode', 98, 1, NULL, 1, 2, '2021-06-27 13:33:55', '2025-04-28 21:25:13', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (4, 2, '七牛云', '3', 'upload_mode', 97, 1, NULL, 1, 1, '2021-06-27 13:34:07', '2025-03-28 19:35:25', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (5, 2, '腾讯云COS', '4', 'upload_mode', 96, 1, NULL, 1, 1, '2021-06-27 13:34:19', '2025-03-28 19:35:25', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (6, 2, '亚马逊S3', '5', 'upload_mode', 95, 1, '', 1, 1, '2021-06-27 13:34:19', '2025-04-04 23:05:31', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (7, 3, '正常', '1', 'data_status', 0, 1, '1为正常', 1, 1, '2021-06-27 13:36:51', '2021-06-27 13:37:01', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (8, 3, '停用', '2', 'data_status', 0, 1, '2为停用', 1, 1, '2021-06-27 13:37:10', '2021-06-27 13:37:10', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (9, 4, '统计页面', 'statistics', 'dashboard', 0, 1, '管理员用', 1, 1, '2021-08-09 12:53:53', '2023-11-16 11:39:17', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (10, 4, '工作台', 'work', 'dashboard', 0, 1, '员工使用', 1, 1, '2021-08-09 12:54:18', '2021-08-09 12:54:18', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (11, 5, '男', '1', 'gender', 0, 1, NULL, 1, 1, '2021-08-09 12:55:00', '2025-04-04 23:05:52', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (12, 5, '女', '2', 'gender', 0, 1, NULL, 1, 1, '2021-08-09 12:55:08', '2025-04-04 23:05:52', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (13, 5, '未知', '3', 'gender', 0, 1, NULL, 1, 1, '2021-08-09 12:55:16', '2025-04-04 23:05:52', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (14, 7, '通知', '1', 'backend_notice_type', 2, 1, NULL, 1, 1, '2021-11-11 17:29:27', '2021-11-11 17:30:51', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (15, 7, '公告', '2', 'backend_notice_type', 1, 1, NULL, 1, 1, '2021-11-11 17:31:42', '2021-11-11 17:31:42', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (16, 12, '图片', 'image', 'attachment_type', 10, 1, NULL, 1, 1, '2022-03-17 14:49:59', '2022-03-17 14:49:59', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (17, 12, '文档', 'text', 'attachment_type', 9, 1, NULL, 1, 1, '2022-03-17 14:50:20', '2022-03-17 14:50:49', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (18, 12, '音频', 'audio', 'attachment_type', 8, 1, NULL, 1, 1, '2022-03-17 14:50:37', '2022-03-17 14:50:52', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (19, 12, '视频', 'video', 'attachment_type', 7, 1, NULL, 1, 1, '2022-03-17 14:50:45', '2022-03-17 14:50:57', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (20, 12, '应用程序', 'application', 'attachment_type', 6, 1, NULL, 1, 1, '2022-03-17 14:50:52', '2022-03-17 14:50:59', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (21, 13, '菜单', 'M', 'menu_type', 100, 1, '', 1, 1, '2024-07-31 10:34:12', '2024-07-31 10:34:12', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (22, 13, '按钮', 'B', 'menu_type', 100, 1, '', 1, 1, '2024-07-31 10:34:20', '2024-07-31 10:34:20', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (23, 13, '外链', 'L', 'menu_type', 100, 1, '', 1, 1, '2024-07-31 10:34:27', '2024-07-31 10:34:27', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (24, 13, 'iFrame', 'I', 'menu_type', 100, 1, '', 1, 1, '2024-07-31 10:34:51', '2024-07-31 10:34:51', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (25, 14, '是', '1', 'yes_or_no', 100, 1, '', 1, 1, '2024-07-31 10:35:17', '2024-07-31 10:35:17', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (26, 14, '否', '2', 'yes_or_no', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2024-07-31 10:35:22', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (45, 17, '纸张大小', 'paperSize', 'print_option_type', 1, 1, NULL, NULL, NULL, '2025-07-16 14:32:59', '2025-07-16 14:32:59', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (46, 17, '色彩', 'color', 'print_option_type', 2, 1, NULL, NULL, NULL, '2025-07-16 14:32:59', '2025-07-16 14:32:59', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (47, 17, '单双面', 'side', 'print_option_type', 3, 1, NULL, NULL, NULL, '2025-07-16 14:32:59', '2025-07-16 14:32:59', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (48, 17, '纸张类型', 'paperType', 'print_option_type', 4, 1, NULL, NULL, NULL, '2025-07-16 14:32:59', '2025-07-16 14:32:59', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (49, 17, '纸张克重', 'paperWeight', 'print_option_type', 5, 1, NULL, NULL, NULL, '2025-07-16 14:32:59', '2025-07-16 14:32:59', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (50, 17, '份数', 'copies', 'print_option_type', 6, 1, NULL, NULL, NULL, '2025-07-16 14:32:59', '2025-07-16 14:32:59', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (52, 17, '装订', 'binding', 'print_option_type', 8, 1, NULL, NULL, NULL, '2025-07-16 14:32:59', '2025-07-16 14:32:59', NULL, NULL);
INSERT INTO `sa_system_dict_data` VALUES (53, 18, '禁用', '1', 'is_disable', 1, 1, '', NULL, 1, '2025-07-16 14:34:10', '2025-07-18 11:12:57', NULL, '#141514');
INSERT INTO `sa_system_dict_data` VALUES (54, 18, '正常', '0', 'is_disable', 2, 1, '', NULL, 1, '2025-07-16 14:34:10', '2025-07-18 11:38:29', NULL, '#3FBB4D');
INSERT INTO `sa_system_dict_data` VALUES (55, 17, '缩印', 'multiPage', 'print_option_type', 9, 1, '', 1, 1, '2025-07-22 14:28:54', '2025-07-22 14:40:54', NULL, '');
INSERT INTO `sa_system_dict_data` VALUES (56, 17, '装订类型', 'binding', 'print_option_type', 10, 1, '', 1, 1, '2025-07-22 14:41:38', '2025-07-22 14:42:09', NULL, '');
INSERT INTO `sa_system_dict_data` VALUES (57, 17, '封面类型', 'coverType', 'print_option_type', 11, 1, '', 1, 1, '2025-07-22 14:42:33', '2025-07-22 14:42:33', NULL, '');
INSERT INTO `sa_system_dict_data` VALUES (58, 17, '封面颜色', 'coverColor', 'print_option_type', 12, 1, '', 1, 1, '2025-07-22 14:42:52', '2025-07-22 14:42:52', NULL, '');
INSERT INTO `sa_system_dict_data` VALUES (59, 17, '封面内容', 'coverContent', 'print_option_type', 13, 1, '', 1, 1, '2025-07-22 14:43:20', '2025-07-22 14:43:20', NULL, '');

-- ----------------------------
-- Table structure for sa_system_dict_type
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_dict_type`;
CREATE TABLE `sa_system_dict_type`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典标示',
  `status` smallint NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '字典类型表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_dict_type
-- ----------------------------
INSERT INTO `sa_system_dict_type` VALUES (2, '存储模式', 'upload_mode', 1, '上传文件存储模式', 1, 1, '2021-06-27 13:33:29', '2025-04-04 23:02:52', NULL);
INSERT INTO `sa_system_dict_type` VALUES (3, '数据状态', 'data_status', 1, '通用数据状态', 1, 1, '2021-06-27 13:33:29', '2025-03-29 20:39:25', NULL);
INSERT INTO `sa_system_dict_type` VALUES (4, '后台首页', 'dashboard', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2023-11-16 11:28:17', NULL);
INSERT INTO `sa_system_dict_type` VALUES (5, '性别', 'gender', 1, '', 1, 1, '2021-06-27 13:33:29', '2025-04-04 23:05:52', NULL);
INSERT INTO `sa_system_dict_type` VALUES (7, '后台公告类型', 'backend_notice_type', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2021-11-11 17:29:14', NULL);
INSERT INTO `sa_system_dict_type` VALUES (12, '附件类型', 'attachment_type', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2022-03-17 14:49:23', NULL);
INSERT INTO `sa_system_dict_type` VALUES (13, '菜单类型', 'menu_type', 1, '', 1, 1, '2024-07-31 10:33:37', '2024-07-31 10:33:37', NULL);
INSERT INTO `sa_system_dict_type` VALUES (14, '是否', 'yes_or_no', 1, '', 1, 1, '2024-07-31 10:35:07', '2024-07-31 10:35:07', NULL);
INSERT INTO `sa_system_dict_type` VALUES (17, '打印选项类型', 'print_option_type', 1, '打印设置选项类型', 1, 1, '2025-07-16 14:30:44', '2025-07-16 14:30:44', NULL);
INSERT INTO `sa_system_dict_type` VALUES (18, '是否禁用', 'is_disable', 1, '是否禁用', NULL, 1, '2025-07-16 14:33:26', '2025-07-18 11:06:49', NULL);

-- ----------------------------
-- Table structure for sa_system_login_log
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_login_log`;
CREATE TABLE `sa_system_login_log`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '登录IP地址',
  `ip_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'IP所属地',
  `os` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '操作系统',
  `browser` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '浏览器',
  `status` smallint NULL DEFAULT 1 COMMENT '登录状态 (1成功 2失败)',
  `message` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '提示消息',
  `login_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '登录时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '更新时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '登录日志表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_login_log
-- ----------------------------
INSERT INTO `sa_system_login_log` VALUES (2, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-18 11:42:24', NULL, 1, 1, '2025-07-18 11:42:25', '2025-07-18 11:42:25', NULL);
INSERT INTO `sa_system_login_log` VALUES (3, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-18 14:38:51', NULL, 1, 1, '2025-07-18 14:38:51', '2025-07-18 14:38:51', NULL);
INSERT INTO `sa_system_login_log` VALUES (4, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-21 09:12:26', NULL, 1, 1, '2025-07-21 09:12:27', '2025-07-21 09:12:27', NULL);
INSERT INTO `sa_system_login_log` VALUES (5, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-21 15:53:21', NULL, 1, 1, '2025-07-21 15:53:21', '2025-07-21 15:53:21', NULL);
INSERT INTO `sa_system_login_log` VALUES (6, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-22 14:28:06', NULL, 1, 1, '2025-07-22 14:28:07', '2025-07-22 14:28:07', NULL);
INSERT INTO `sa_system_login_log` VALUES (7, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-24 11:23:38', NULL, 1, 1, '2025-07-24 11:23:39', '2025-07-24 11:23:39', NULL);
INSERT INTO `sa_system_login_log` VALUES (8, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-24 14:36:10', NULL, 1, 1, '2025-07-24 14:36:11', '2025-07-24 14:36:11', NULL);
INSERT INTO `sa_system_login_log` VALUES (9, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-25 09:31:11', NULL, 1, 1, '2025-07-25 09:31:11', '2025-07-25 09:31:11', NULL);
INSERT INTO `sa_system_login_log` VALUES (10, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-28 10:29:36', NULL, 1, 1, '2025-07-28 10:29:36', '2025-07-28 10:29:36', NULL);
INSERT INTO `sa_system_login_log` VALUES (11, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-28 13:37:11', NULL, 1, 1, '2025-07-28 13:37:12', '2025-07-28 13:37:12', NULL);
INSERT INTO `sa_system_login_log` VALUES (12, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-28 13:39:36', NULL, 1, 1, '2025-07-28 13:39:37', '2025-07-28 13:39:37', NULL);
INSERT INTO `sa_system_login_log` VALUES (13, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-28 14:05:22', NULL, 1, 1, '2025-07-28 14:05:22', '2025-07-28 14:05:22', NULL);
INSERT INTO `sa_system_login_log` VALUES (14, 'admin', '172.18.0.1', '内网IP', 'Win', 'Chrome', 1, '登录成功', '2025-07-28 16:22:58', NULL, 1, 1, '2025-07-28 16:22:59', '2025-07-28 16:22:59', NULL);

-- ----------------------------
-- Table structure for sa_system_mail
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_mail`;
CREATE TABLE `sa_system_mail`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `gateway` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '网关',
  `from` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '发送人',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '接收人',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '验证码',
  `content` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '邮箱内容',
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '发送状态',
  `response` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '返回结果',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '邮件记录' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_mail
-- ----------------------------

-- ----------------------------
-- Table structure for sa_system_menu
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_menu`;
CREATE TABLE `sa_system_menu`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `parent_id` int UNSIGNED NULL DEFAULT NULL COMMENT '父ID',
  `level` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '组级集合',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '菜单名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '菜单标识代码',
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '菜单图标',
  `route` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '路由地址',
  `component` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '组件路径',
  `redirect` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '跳转地址',
  `is_hidden` smallint NULL DEFAULT 1 COMMENT '是否隐藏 (1是 2否)',
  `is_layout` tinyint UNSIGNED NULL DEFAULT 1 COMMENT '继承layout',
  `type` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '菜单类型, (M菜单 B按钮 L链接 I iframe)',
  `generate_id` int NULL DEFAULT 0 COMMENT '生成id',
  `generate_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '生成key',
  `status` smallint NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `sort` smallint UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6012 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '菜单信息表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_menu
-- ----------------------------
INSERT INTO `sa_system_menu` VALUES (1000, 0, '0', '权限', 'permission', 'IconSafe', 'permission', '', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1100, 1000, '0,1000', '用户管理', 'permission/user', 'IconUserGroup', 'permission/user', 'system/user/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1101, 1100, '0,1000,1100', '用户列表', '/core/user/index', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1102, 1100, '0,1000,1100', '用户保存', '/core/user/save', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1103, 1100, '0,1000,1100', '用户更新', '/core/user/update', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1104, 1100, '0,1000,1100', '用户删除', '/core/user/destroy', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1105, 1100, '0,1000,1100', '用户读取', '/core/user/read', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1106, 1100, '0,1000,1100', '用户状态改变', '/core/user/changeStatus', '', NULL, '', NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1107, 1100, '0,1000,1100', '用户重置密码', '/core/user/initUserPassword', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1108, 1100, '0,1000,1100', '更新用户缓存', '/core/user/clearCache', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1109, 1100, '0,1000,1100', '设置用户首页', '/core/user/setHomePage', '', NULL, '', NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1200, 1000, '0,1000', '菜单管理', 'permission/menu', 'IconMenu', 'permission/menu', 'system/menu/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1201, 1200, '0,1000,1200', '菜单列表', '/core/menu/index', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1202, 1200, '0,1000,1200', '菜单保存', '/core/menu/save', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1203, 1200, '0,1000,1200', '菜单更新', '/core/menu/update', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1204, 1200, '0,1000,1200', '菜单删除', '/core/menu/destroy', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1205, 1200, '0,1000,1200', '菜单读取', '/core/menu/read', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1300, 1000, '0,1000', '部门管理', 'permission/dept', 'IconMindMapping', 'permission/dept', 'system/dept/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1301, 1300, '0,1000,1300', '部门列表', '/core/dept/index', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1302, 1300, '0,1000,1300', '部门保存', '/core/dept/save', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1303, 1300, '0,1000,1300', '部门更新', '/core/dept/update', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1304, 1300, '0,1000,1300', '部门删除', '/core/dept/destroy', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1305, 1300, '0,1000,1300', '部门读取', '/core/dept/read', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1306, 1300, '0,1000,1300', '部门领导', '/core/dept/leaders', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1400, 1000, '0,1000', '角色管理', 'permission/role', 'IconLock', 'permission/role', 'system/role/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1401, 1400, '0,1000,1400', '角色列表', '/core/role/index', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1402, 1400, '0,1000,1400', '角色保存', '/core/role/save', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1403, 1400, '0,1000,1400', '角色更新', '/core/role/update', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1404, 1400, '0,1000,1400', '角色删除', '/core/role/destroy', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1405, 1400, '0,1000,1400', '角色读取', '/core/role/read', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1406, 1400, '0,1000,1400', '角色菜单权限', '/core/role/menuPermission', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1500, 1000, '0,1000', '岗位管理', 'permission/post', 'IconTags', 'permission/post', 'system/post/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1501, 1500, '0,1000,1500', '岗位列表', '/core/post/index', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1502, 1500, '0,1000,1500', '岗位保存', '/core/post/save', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1503, 1500, '0,1000,1500', '岗位更新', '/core/post/update', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1504, 1500, '0,1000,1500', '岗位删除', '/core/post/destroy', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1505, 1500, '0,1000,1500', '岗位读取', '/core/post/read', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1506, 1500, '0,1000,1500', '岗位状态改变', '/core/post/changeStatus', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1507, 1500, '0,1000,1500', '岗位导入', '/core/post/import', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (1508, 1500, '0,1000,1500', '岗位导出', '/core/post/export', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2000, 0, '0', '数据', 'data', 'IconStorage', 'data', '', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2100, 2000, '0,2000', '数据字典', 'data/dict', 'IconBook', 'data/dict', 'system/dict/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2101, 2100, '0,2000,2100', '数据字典列表', '/core/dictType/index', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2102, 2100, '0,2000,2100', '数据字典保存', '/core/dictType/save', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2103, 2100, '0,2000,2100', '数据字典更新', '/core/dictType/update', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2104, 2100, '0,2000,2100', '数据字典删除', '/core/dictType/destroy', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2105, 2100, '0,2000,2100', '数据字典读取', '/core/dictType/read', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2106, 2100, '0,2000,2100', '字典状态改变', '/core/dictType/changeStatus', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2200, 2000, '0,2000', '附件管理', 'data/attachment', 'IconAttachment', 'data/attachment', 'system/attachment/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2201, 2200, '0,2000,2200', '附件删除', '/core/attachment/destroy', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2202, 2200, '0,2000,2200', '附件列表', '/core/attachment/index', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2300, 2000, '0,2000', '数据表维护', 'data/database', 'IconNav', 'data/database', 'system/database/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2301, 2300, '0,2000,2300', '数据表列表', '/core/database/index', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2302, 2300, '0,2000,2300', '数据表详细', '/core/database/detailed', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2303, 2300, '0,2000,2300', '数据表清理碎片', '/core/database/fragment', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2304, 2300, '0,2000,2300', '数据表优化', '/core/database/optimize', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2305, 2300, '0,2000,2300', '数据回收站', '/core/database/recycle', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2306, 2300, '0,2000,2300', '数据销毁', '/core/database/delete', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2307, 2300, '0,2000,2300', '数据恢复', '/core/database/recovery', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2700, 2000, '0,2000', '系统公告', 'data/notice', 'IconNotification', 'data/notice', 'system/notice/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2701, 2700, '0,2000,2700', '系统公告列表', '/core/notice/index', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2702, 2700, '0,2000,2700', '系统公告保存', '/core/notice/save', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2703, 2700, '0,2000,2700', '系统公告更新', '/core/notice/update', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2704, 2700, '0,2000,2700', '系统公告删除', '/core/notice/destroy', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (2705, 2700, '0,2000,2700', '系统公告读取', '/core/notice/read', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3000, 0, '0', '监控', 'monitor', 'IconComputer', 'monitor', '', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3200, 3000, '0,3000', '服务监控', 'monitor/server', 'IconDashboard', 'monitor/server', 'system/monitor/server/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3300, 3000, '0,3000', '日志监控', 'monitor/logs', 'IconRobot', 'monitor/logs', '', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3400, 3300, '0,3000,3300', '登录日志', 'monitor/logs/loginLog', 'IconImport', 'monitor/logs/loginLog', 'system/logs/loginLog', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3401, 3400, '0,3000,3300,3400', '登录日志列表', '/core/logs/getLoginLogPageList', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3402, 3400, '0,3000,3200,3300', '登录日志删除', '/core/logs/deleteOperLog', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3500, 3300, '0,3000,3300', '操作日志', 'monitor/logs/operLog', 'IconInfoCircle', 'monitor/logs/operLog', 'system/logs/operLog', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3501, 3500, '0,3000,3300,3500', '操作日志列表', '/core/logs/getOperLogPageList', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3502, 3500, '0,3000,3200,3500', '操作日志删除', '/core/logs/deleteOperLog', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3600, 3000, '0,3000', '邮件记录', 'monitor/emailLog', 'IconEmail', 'monitor/emailLog', 'system/logs/emailLog', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3601, 3600, '0,3000,3600', '邮件记录删除', '/core/email/destroy', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3602, 3600, '0,3000,3600', '邮件记录列表', '/core/email/index', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (3700, 3200, '0,3000,3200', '服务监控列表', '/core/system/monitor', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4000, 0, '0', '工具', 'tool', 'IconTool', 'tool', '', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4100, 4000, '0,4000', '代码生成器', 'tool/code', 'IconCodeSquare', 'tool/code', 'tool/code/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4101, 4100, '0,4000,4100', '代码生成列表', '/tool/code/index', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4102, 4100, '0,4000,4100', '功能操作', '/tool/code/access', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4200, 4000, '0,4000', '定时任务', 'tool/crontab', 'IconSchedule', 'tool/crontab', 'tool/crontab/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4201, 4200, '0,4000,4200', '定时任务列表', '/tool/crontab/index', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4202, 4200, '0,4000,4200', '定时任务保存', '/tool/crontab/save', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4203, 4200, '0,4000,4200', '定时任务更新', '/tool/crontab/update', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4204, 4200, '0,4000,4200', '定时任务删除', '/tool/crontab/destroy', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4205, 4200, '0,4000,4200', '定时任务读取', '/tool/crontab/read', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4206, 4200, '0,4000,4200', '定时任务状态修改', '/tool/crontab/changeStatus', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4207, 4200, '0,4000,4200', '定时任务执行', '/tool/crontab/run', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (4208, 4200, '0,4000,4200', '定时任务日志删除', '/tool/crontab/deleteLog', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (5000, 0, '0', '系统设置', 'config', 'IconSettings', 'config', 'system/config/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (5001, 5000, '0,5000', '配置列表', '/core/config/index', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (5002, 5000, '0,5000', '新增配置 ', '/core/config/save', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (5003, 5000, '0,5000', '更新配置', '/core/config/update', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (5004, 5000, '0,5000', '删除配置', '/core/config/destroy', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (5005, 5000, '0,5000', '配置读取', '/core/config/read', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (5100, 0, '0', '附加数据', 'addition', 'IconRelation', 'addition', '', NULL, 1, 1, 'M', 0, NULL, 2, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (5101, 5100, '0,5100', '用户列表接口', '/core/system/getUserList', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (5102, 5100, '0,5100', '用户信息接口', '/core/system/getUserInfoByIds', '', '', '', NULL, 2, 1, 'B', 0, NULL, 1, 0, '', 1, 1, '2025-04-30 13:56:46', '2025-04-30 13:56:46', NULL);
INSERT INTO `sa_system_menu` VALUES (6000, 0, '0,0', '打印设置', '', 'icon-home', 'printSetting/setting', 'printSetting/setting/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, NULL, NULL, NULL, '2025-07-18 10:57:18', '2025-07-18 10:57:18', NULL);
INSERT INTO `sa_system_menu` VALUES (6001, 6000, '0,6000', '打印设置列表', '/backend/printSetting/PrintSetting/index', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, NULL, NULL, '2025-07-18 10:57:18', '2025-07-18 10:57:18', NULL);
INSERT INTO `sa_system_menu` VALUES (6002, 6000, '0,6000', '打印设置保存', '/backend/printSetting/PrintSetting/save', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, NULL, NULL, '2025-07-18 10:57:18', '2025-07-18 10:57:18', NULL);
INSERT INTO `sa_system_menu` VALUES (6003, 6000, '0,6000', '打印设置更新', '/backend/printSetting/PrintSetting/update', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, NULL, NULL, '2025-07-18 10:57:18', '2025-07-18 10:57:18', NULL);
INSERT INTO `sa_system_menu` VALUES (6004, 6000, '0,6000', '打印设置读取', '/backend/printSetting/PrintSetting/read', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, NULL, NULL, '2025-07-18 10:57:18', '2025-07-18 10:57:18', NULL);
INSERT INTO `sa_system_menu` VALUES (6005, 6000, '0,6000', '打印设置删除', '/backend/printSetting/PrintSetting/destroy', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, NULL, NULL, '2025-07-18 10:57:18', '2025-07-18 10:57:18', NULL);
INSERT INTO `sa_system_menu` VALUES (6006, 0, '0,0', '优惠券模板表', '', 'icon-home', 'CouponTemplate/template', 'CouponTemplate/template/index', NULL, 2, 1, 'M', 0, NULL, 1, 0, NULL, NULL, NULL, '2025-07-28 14:47:56', '2025-07-28 14:47:56', NULL);
INSERT INTO `sa_system_menu` VALUES (6007, 6006, '0,6006', '优惠券模板表列表', '/backend/CouponTemplate/CouponTemplate/index', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, NULL, NULL, '2025-07-28 14:47:56', '2025-07-28 14:47:56', NULL);
INSERT INTO `sa_system_menu` VALUES (6008, 6006, '0,6006', '优惠券模板表保存', '/backend/CouponTemplate/CouponTemplate/save', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, NULL, NULL, '2025-07-28 14:47:56', '2025-07-28 14:47:56', NULL);
INSERT INTO `sa_system_menu` VALUES (6009, 6006, '0,6006', '优惠券模板表更新', '/backend/CouponTemplate/CouponTemplate/update', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, NULL, NULL, '2025-07-28 14:47:56', '2025-07-28 14:47:56', NULL);
INSERT INTO `sa_system_menu` VALUES (6010, 6006, '0,6006', '优惠券模板表读取', '/backend/CouponTemplate/CouponTemplate/read', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, NULL, NULL, '2025-07-28 14:47:56', '2025-07-28 14:47:56', NULL);
INSERT INTO `sa_system_menu` VALUES (6011, 6006, '0,6006', '优惠券模板表删除', '/backend/CouponTemplate/CouponTemplate/destroy', NULL, NULL, NULL, NULL, 2, 1, 'B', 0, NULL, 1, 0, NULL, NULL, NULL, '2025-07-28 14:47:56', '2025-07-28 14:47:56', NULL);

-- ----------------------------
-- Table structure for sa_system_notice
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_notice`;
CREATE TABLE `sa_system_notice`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `message_id` int NULL DEFAULT NULL COMMENT '消息ID',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '标题',
  `type` smallint NULL DEFAULT NULL COMMENT '公告类型(1通知 2公告)',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '公告内容',
  `click_num` int NULL DEFAULT 0 COMMENT '浏览次数',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建人',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新人',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `message_id`(`message_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统公告表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_notice
-- ----------------------------
INSERT INTO `sa_system_notice` VALUES (1, NULL, '欢迎使用SaiAdmin', 1, '<p>saiadmin是一款基于vue3 + webman 的极速开发框架，前端开发采用JavaScript，后端采用PHP</p>', 0, '', 1, 1, '2024-01-20 15:55:36', '2025-04-04 23:27:30', NULL);

-- ----------------------------
-- Table structure for sa_system_oper_log
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_oper_log`;
CREATE TABLE `sa_system_oper_log`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `app` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '应用名称',
  `method` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '请求方式',
  `router` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '请求路由',
  `service_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '业务名称',
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '请求IP地址',
  `ip_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'IP所属地',
  `request_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '请求数据',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '更新时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '操作日志表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_oper_log
-- ----------------------------
INSERT INTO `sa_system_oper_log` VALUES (8, 'admin', 'saiadmin', 'PUT', '/core/dictdata/update?id=54', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"54\",\"type_id\":18,\"code\":\"\",\"label\":\"否\",\"value\":\"0\",\"color\":\"#3F3F3F\",\"status\":1,\"sort\":2,\"remark\":\"\"}', NULL, 1, 1, '2025-07-18 10:45:29', '2025-07-18 10:45:29', NULL);
INSERT INTO `sa_system_oper_log` VALUES (9, 'admin', 'saiadmin', 'PUT', '/core/dictdata/update?id=52', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"52\",\"type_id\":17,\"code\":\"\",\"label\":\"装订\",\"value\":\"binding\",\"color\":\"#626262\",\"status\":1,\"sort\":8,\"remark\":\"\"}', NULL, 1, 1, '2025-07-18 10:47:02', '2025-07-18 10:47:02', NULL);
INSERT INTO `sa_system_oper_log` VALUES (10, 'admin', 'saiadmin', 'PUT', '/core/dictdata/update?id=54', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"54\",\"type_id\":18,\"code\":\"yes_no\",\"label\":\"否\",\"value\":\"0\",\"color\":\"#575757\",\"status\":1,\"sort\":2,\"remark\":\"\"}', NULL, 1, 1, '2025-07-18 10:47:13', '2025-07-18 10:47:13', NULL);
INSERT INTO `sa_system_oper_log` VALUES (11, 'admin', 'saiadmin', 'PUT', '/core/dictdata/update?id=53', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"53\",\"type_id\":18,\"code\":\"yes_no\",\"label\":\"是\",\"value\":\"1\",\"color\":\"#C39D3B\",\"status\":1,\"sort\":1,\"remark\":\"\"}', NULL, 1, 1, '2025-07-18 10:47:27', '2025-07-18 10:47:27', NULL);
INSERT INTO `sa_system_oper_log` VALUES (12, 'admin', 'saiadmin', 'POST', '/tool/code/loadtable', '未命名业务', '172.18.0.1', '内网IP', '{\"source\":\"mysql\",\"names\":[{\"name\":\"sa_print_setting\",\"comment\":\"打印设置表\",\"sourceName\":\"sa_print_setting\"}]}', NULL, 1, 1, '2025-07-18 10:52:09', '2025-07-18 10:52:09', NULL);
INSERT INTO `sa_system_oper_log` VALUES (13, 'admin', 'saiadmin', 'PUT', '/tool/code/update?id=1', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"1\",\"generate_menus\":[\"index\",\"save\",\"update\",\"read\",\"delete\"],\"columns\":[{\"id\":1,\"table_id\":1,\"column_name\":\"id\",\"column_comment\":\"ID\",\"column_type\":\"int\",\"default_value\":null,\"is_pk\":2,\"is_required\":true,\"is_insert\":false,\"is_edit\":false,\"is_list\":false,\"is_query\":false,\"is_sort\":false,\"query_type\":\"eq\",\"view_type\":\"input\",\"dict_type\":null,\"allow_roles\":null,\"options\":null,\"sort\":10,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-18 10:52:09\",\"update_time\":\"2025-07-18 10:52:09\"},{\"id\":2,\"table_id\":1,\"column_name\":\"type\",\"column_comment\":\"选项类型\",\"column_type\":\"varchar\",\"default_value\":null,\"is_pk\":1,\"is_required\":true,\"is_insert\":false,\"is_edit\":false,\"is_list\":false,\"is_query\":true,\"is_sort\":false,\"query_type\":\"eq\",\"view_type\":\"saSelect\",\"dict_type\":\"print_option_type\",\"allow_roles\":null,\"options\":null,\"sort\":9,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-18 10:52:09\",\"update_time\":\"2025-07-18 10:52:09\"},{\"id\":3,\"table_id\":1,\"column_name\":\"name\",\"column_comment\":\"选项名称\",\"column_type\":\"varchar\",\"default_value\":null,\"is_pk\":1,\"is_required\":true,\"is_insert\":true,\"is_edit\":true,\"is_list\":true,\"is_query\":true,\"is_sort\":false,\"query_type\":\"like\",\"view_type\":\"input\",\"dict_type\":null,\"allow_roles\":null,\"options\":null,\"sort\":8,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-18 10:52:09\",\"update_time\":\"2025-07-18 10:52:09\"},{\"id\":4,\"table_id\":1,\"column_name\":\"value\",\"column_comment\":\"选项值\",\"column_type\":\"varchar\",\"default_value\":null,\"is_pk\":1,\"is_required\":true,\"is_insert\":true,\"is_edit\":true,\"is_list\":true,\"is_query\":false,\"is_sort\":false,\"query_type\":\"eq\",\"view_type\":\"input\",\"dict_type\":null,\"allow_roles\":null,\"options\":null,\"sort\":7,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-18 10:52:09\",\"update_time\":\"2025-07-18 10:52:09\"},{\"id\":5,\"table_id\":1,\"column_name\":\"price\",\"column_comment\":\"价格\",\"column_type\":\"decimal\",\"default_value\":\"0.00\",\"is_pk\":1,\"is_required\":true,\"is_insert\":true,\"is_edit\":true,\"is_list\":true,\"is_query\":false,\"is_sort\":false,\"query_type\":\"eq\",\"view_type\":\"input\",\"dict_type\":null,\"allow_roles\":null,\"options\":null,\"sort\":6,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-18 10:52:09\",\"update_time\":\"2025-07-18 10:52:09\"},{\"id\":6,\"table_id\":1,\"column_name\":\"sort\",\"column_comment\":\"排序\",\"column_type\":\"int\",\"default_value\":\"0\",\"is_pk\":1,\"is_required\":true,\"is_insert\":true,\"is_edit\":true,\"is_list\":true,\"is_query\":false,\"is_sort\":false,\"query_type\":\"eq\",\"view_type\":\"input\",\"dict_type\":null,\"allow_roles\":null,\"options\":null,\"sort\":5,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-18 10:52:09\",\"update_time\":\"2025-07-18 10:52:09\"},{\"id\":7,\"table_id\":1,\"column_name\":\"is_default\",\"column_comment\":\"是否默认\",\"column_type\":\"tinyint\",\"default_value\":\"0\",\"is_pk\":1,\"is_required\":true,\"is_insert\":true,\"is_edit\":true,\"is_list\":true,\"is_query\":false,\"is_sort\":false,\"query_type\":\"eq\",\"view_type\":\"saSelect\",\"dict_type\":\"yes_or_no\",\"allow_roles\":null,\"options\":null,\"sort\":4,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-18 10:52:09\",\"update_time\":\"2025-07-18 10:52:09\"},{\"id\":8,\"table_id\":1,\"column_name\":\"status\",\"column_comment\":\"状态\",\"column_type\":\"tinyint\",\"default_value\":\"0\",\"is_pk\":1,\"is_required\":true,\"is_insert\":true,\"is_edit\":true,\"is_list\":true,\"is_query\":false,\"is_sort\":false,\"query_type\":\"eq\",\"view_type\":\"saSelect\",\"dict_type\":\"yes_no\",\"allow_roles\":null,\"options\":null,\"sort\":3,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-18 10:52:09\",\"update_time\":\"2025-07-18 10:52:09\"},{\"id\":9,\"table_id\":1,\"column_name\":\"create_time\",\"column_comment\":\"创建时间\",\"column_type\":\"datetime\",\"default_value\":null,\"is_pk\":1,\"is_required\":false,\"is_insert\":false,\"is_edit\":false,\"is_list\":false,\"is_query\":true,\"is_sort\":false,\"query_type\":\"between\",\"view_type\":\"date\",\"dict_type\":null,\"allow_roles\":null,\"options\":{\"mode\":\"date\",\"showTime\":true},\"sort\":2,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-18 10:52:09\",\"update_time\":\"2025-07-18 10:52:09\"},{\"id\":10,\"table_id\":1,\"column_name\":\"update_time\",\"column_comment\":\"更新时间\",\"column_type\":\"datetime\",\"default_value\":null,\"is_pk\":1,\"is_required\":false,\"is_insert\":false,\"is_edit\":false,\"is_list\":false,\"is_query\":false,\"is_sort\":false,\"query_type\":\"between\",\"view_type\":\"date\",\"dict_type\":null,\"allow_roles\":null,\"options\":{\"mode\":\"date\",\"showTime\":true},\"sort\":1,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-18 10:52:09\",\"update_time\":\"2025-07-18 10:52:09\"}],\"table_name\":\"sa_print_setting\",\"table_comment\":\"打印设置表\",\"stub\":\"saiadmin\",\"template\":\"app\",\"namespace\":\"printSetting\",\"package_name\":\"\",\"business_name\":\"setting\",\"class_name\":\"PrintSetting\",\"menu_name\":\"打印设置\",\"belong_menu_id\":0,\"tpl_category\":\"single\",\"generate_type\":1,\"generate_path\":\"saiadmin-vue\",\"generate_model\":1,\"build_menu\":1,\"component_type\":1,\"options\":{\"relations\":[]},\"form_width\":600,\"is_full\":1,\"remark\":null,\"source\":\"mysql\",\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-18 10:52:09\",\"update_time\":\"2025-07-18 10:52:09\"}', NULL, 1, 1, '2025-07-18 10:53:52', '2025-07-18 10:53:52', NULL);
INSERT INTO `sa_system_oper_log` VALUES (14, 'admin', 'saiadmin', 'POST', '/tool/code/generate', '未命名业务', '172.18.0.1', '内网IP', '{\"ids\":[\"1\"]}', NULL, 1, 1, '2025-07-18 10:56:08', '2025-07-18 10:56:08', NULL);
INSERT INTO `sa_system_oper_log` VALUES (15, 'admin', 'saiadmin', 'PUT', '/core/dicttype/update?id=18', '数据字典更新', '172.18.0.1', '内网IP', '{\"id\":\"18\",\"name\":\"是否\",\"code\":\"is_disable\",\"status\":1,\"remark\":\"是否禁用\"}', NULL, 1, 1, '2025-07-18 11:06:43', '2025-07-18 11:06:43', NULL);
INSERT INTO `sa_system_oper_log` VALUES (16, 'admin', 'saiadmin', 'PUT', '/core/dicttype/update?id=18', '数据字典更新', '172.18.0.1', '内网IP', '{\"id\":\"18\",\"name\":\"是否禁用\",\"code\":\"is_disable\",\"status\":1,\"remark\":\"是否禁用\"}', NULL, 1, 1, '2025-07-18 11:06:49', '2025-07-18 11:06:49', NULL);
INSERT INTO `sa_system_oper_log` VALUES (17, 'admin', 'saiadmin', 'PUT', '/core/dictdata/update?id=54', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"54\",\"type_id\":18,\"code\":\"is_disable\",\"label\":\"禁用\",\"value\":\"0\",\"color\":\"\",\"status\":1,\"sort\":2,\"remark\":\"\"}', NULL, 1, 1, '2025-07-18 11:06:59', '2025-07-18 11:06:59', NULL);
INSERT INTO `sa_system_oper_log` VALUES (18, 'admin', 'saiadmin', 'PUT', '/core/dictdata/update?id=53', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"53\",\"type_id\":18,\"code\":\"is_disable\",\"label\":\"禁用\",\"value\":\"1\",\"color\":\"\",\"status\":1,\"sort\":1,\"remark\":\"\"}', NULL, 1, 1, '2025-07-18 11:07:08', '2025-07-18 11:07:08', NULL);
INSERT INTO `sa_system_oper_log` VALUES (19, 'admin', 'saiadmin', 'PUT', '/core/dictdata/update?id=54', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"54\",\"type_id\":18,\"code\":\"is_disable\",\"label\":\"正常\",\"value\":\"0\",\"color\":\"\",\"status\":1,\"sort\":2,\"remark\":\"\"}', NULL, 1, 1, '2025-07-18 11:07:13', '2025-07-18 11:07:13', NULL);
INSERT INTO `sa_system_oper_log` VALUES (20, 'admin', 'saiadmin', 'PUT', '/core/dictdata/update?id=54', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"54\",\"type_id\":18,\"code\":\"is_disable\",\"label\":\"正常\",\"value\":\"0\",\"color\":\"#434343\",\"status\":1,\"sort\":2,\"remark\":\"\"}', NULL, 1, 1, '2025-07-18 11:12:38', '2025-07-18 11:12:38', NULL);
INSERT INTO `sa_system_oper_log` VALUES (21, 'admin', 'saiadmin', 'PUT', '/core/dictdata/update?id=54', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"54\",\"type_id\":18,\"code\":\"is_disable\",\"label\":\"正常\",\"value\":\"0\",\"color\":\"#3FBB4D\",\"status\":1,\"sort\":2,\"remark\":\"\"}', NULL, 1, 1, '2025-07-18 11:12:51', '2025-07-18 11:12:51', NULL);
INSERT INTO `sa_system_oper_log` VALUES (22, 'admin', 'saiadmin', 'PUT', '/core/dictdata/update?id=53', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"53\",\"type_id\":18,\"code\":\"is_disable\",\"label\":\"禁用\",\"value\":\"1\",\"color\":\"#141514\",\"status\":1,\"sort\":1,\"remark\":\"\"}', NULL, 1, 1, '2025-07-18 11:12:57', '2025-07-18 11:12:57', NULL);
INSERT INTO `sa_system_oper_log` VALUES (23, 'admin', 'saiadmin', 'POST', '/core/dictdata/changestatus', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":54,\"status\":\"2\"}', NULL, 1, 1, '2025-07-18 11:38:26', '2025-07-18 11:38:26', NULL);
INSERT INTO `sa_system_oper_log` VALUES (24, 'admin', 'saiadmin', 'POST', '/core/dictdata/changestatus', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":54,\"status\":\"1\"}', NULL, 1, 1, '2025-07-18 11:38:27', '2025-07-18 11:38:27', NULL);
INSERT INTO `sa_system_oper_log` VALUES (25, 'admin', 'saiadmin', 'POST', '/core/dictdata/changestatus', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":54,\"status\":\"2\"}', NULL, 1, 1, '2025-07-18 11:38:28', '2025-07-18 11:38:28', NULL);
INSERT INTO `sa_system_oper_log` VALUES (26, 'admin', 'saiadmin', 'POST', '/core/dictdata/changestatus', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":54,\"status\":\"1\"}', NULL, 1, 1, '2025-07-18 11:38:29', '2025-07-18 11:38:29', NULL);
INSERT INTO `sa_system_oper_log` VALUES (27, 'admin', 'saiadmin', 'POST', '/core/dictdata/save', '未命名业务', '172.18.0.1', '内网IP', '{\"type_id\":17,\"code\":\"print_option_type\",\"label\":\"缩印\",\"value\":\"multi_page\",\"color\":\"\",\"status\":1,\"sort\":100,\"remark\":\"\"}', NULL, 1, 1, '2025-07-22 14:28:54', '2025-07-22 14:28:54', NULL);
INSERT INTO `sa_system_oper_log` VALUES (28, 'admin', 'saiadmin', 'PUT', '/core/dictdata/update?id=55', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"55\",\"type_id\":17,\"code\":\"print_option_type\",\"label\":\"缩印\",\"value\":\"multi_page\",\"color\":\"\",\"status\":1,\"sort\":9,\"remark\":\"\"}', NULL, 1, 1, '2025-07-22 14:40:54', '2025-07-22 14:40:54', NULL);
INSERT INTO `sa_system_oper_log` VALUES (29, 'admin', 'saiadmin', 'POST', '/core/dictdata/save', '未命名业务', '172.18.0.1', '内网IP', '{\"type_id\":17,\"code\":\"print_option_type\",\"label\":\"封面类型\",\"value\":\"cover_type\",\"color\":\"\",\"status\":1,\"sort\":100,\"remark\":\"\"}', NULL, 1, 1, '2025-07-22 14:41:38', '2025-07-22 14:41:38', NULL);
INSERT INTO `sa_system_oper_log` VALUES (30, 'admin', 'saiadmin', 'PUT', '/core/dictdata/update?id=56', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"56\",\"type_id\":17,\"code\":\"print_option_type\",\"label\":\"装订类型\",\"value\":\"binding\",\"color\":\"\",\"status\":1,\"sort\":10,\"remark\":\"\"}', NULL, 1, 1, '2025-07-22 14:42:09', '2025-07-22 14:42:09', NULL);
INSERT INTO `sa_system_oper_log` VALUES (31, 'admin', 'saiadmin', 'POST', '/core/dictdata/save', '未命名业务', '172.18.0.1', '内网IP', '{\"type_id\":17,\"code\":\"print_option_type\",\"label\":\"封面类型\",\"value\":\"cover_type\",\"color\":\"\",\"status\":1,\"sort\":11,\"remark\":\"\"}', NULL, 1, 1, '2025-07-22 14:42:33', '2025-07-22 14:42:33', NULL);
INSERT INTO `sa_system_oper_log` VALUES (32, 'admin', 'saiadmin', 'POST', '/core/dictdata/save', '未命名业务', '172.18.0.1', '内网IP', '{\"type_id\":17,\"code\":\"print_option_type\",\"label\":\"封面颜色\",\"value\":\"cover_color\",\"color\":\"\",\"status\":1,\"sort\":12,\"remark\":\"\"}', NULL, 1, 1, '2025-07-22 14:42:52', '2025-07-22 14:42:52', NULL);
INSERT INTO `sa_system_oper_log` VALUES (33, 'admin', 'saiadmin', 'POST', '/core/dictdata/save', '未命名业务', '172.18.0.1', '内网IP', '{\"type_id\":17,\"code\":\"print_option_type\",\"label\":\"封面内容\",\"value\":\"cover_content\",\"color\":\"\",\"status\":1,\"sort\":13,\"remark\":\"\"}', NULL, 1, 1, '2025-07-22 14:43:20', '2025-07-22 14:43:20', NULL);
INSERT INTO `sa_system_oper_log` VALUES (34, 'admin', 'saiadmin', 'POST', '/tool/code/generate', '未命名业务', '172.18.0.1', '内网IP', '{\"ids\":[\"1\"]}', NULL, 1, 1, '2025-07-28 10:29:45', '2025-07-28 10:29:45', NULL);
INSERT INTO `sa_system_oper_log` VALUES (35, 'admin', 'saiadmin', 'POST', '/tool/code/loadtable', '未命名业务', '172.18.0.1', '内网IP', '{\"source\":\"mysql\",\"names\":[{\"name\":\"sa_coupon_template\",\"comment\":\"优惠券模板表\",\"sourceName\":\"sa_coupon_template\"}]}', NULL, 1, 1, '2025-07-28 14:45:25', '2025-07-28 14:45:25', NULL);
INSERT INTO `sa_system_oper_log` VALUES (36, 'admin', 'saiadmin', 'PUT', '/tool/code/update?id=2', '未命名业务', '172.18.0.1', '内网IP', '{\"id\":\"2\",\"generate_menus\":[\"index\",\"save\",\"update\",\"read\",\"delete\"],\"columns\":[{\"id\":11,\"table_id\":2,\"column_name\":\"id\",\"column_comment\":\"模板ID\",\"column_type\":\"bigint\",\"default_value\":null,\"is_pk\":2,\"is_required\":true,\"is_insert\":false,\"is_edit\":false,\"is_list\":false,\"is_query\":false,\"is_sort\":false,\"query_type\":\"eq\",\"view_type\":\"input\",\"dict_type\":null,\"allow_roles\":null,\"options\":null,\"sort\":8,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-28 14:45:25\",\"update_time\":\"2025-07-28 14:45:25\"},{\"id\":12,\"table_id\":2,\"column_name\":\"title\",\"column_comment\":\"优惠券标题\",\"column_type\":\"varchar\",\"default_value\":null,\"is_pk\":1,\"is_required\":true,\"is_insert\":true,\"is_edit\":true,\"is_list\":true,\"is_query\":true,\"is_sort\":false,\"query_type\":\"like\",\"view_type\":\"input\",\"dict_type\":null,\"allow_roles\":null,\"options\":null,\"sort\":7,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-28 14:45:25\",\"update_time\":\"2025-07-28 14:45:25\"},{\"id\":13,\"table_id\":2,\"column_name\":\"type\",\"column_comment\":\"优惠券类型\",\"column_type\":\"tinyint\",\"default_value\":\"1\",\"is_pk\":1,\"is_required\":true,\"is_insert\":true,\"is_edit\":true,\"is_list\":true,\"is_query\":true,\"is_sort\":false,\"query_type\":\"eq\",\"view_type\":\"input\",\"dict_type\":null,\"allow_roles\":null,\"options\":null,\"sort\":6,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-28 14:45:25\",\"update_time\":\"2025-07-28 14:45:25\"},{\"id\":14,\"table_id\":2,\"column_name\":\"amount\",\"column_comment\":\"优惠金额\",\"column_type\":\"decimal\",\"default_value\":\"0.00\",\"is_pk\":1,\"is_required\":true,\"is_insert\":true,\"is_edit\":true,\"is_list\":true,\"is_query\":false,\"is_sort\":false,\"query_type\":\"eq\",\"view_type\":\"input\",\"dict_type\":null,\"allow_roles\":null,\"options\":null,\"sort\":5,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-28 14:45:25\",\"update_time\":\"2025-07-28 14:45:25\"},{\"id\":15,\"table_id\":2,\"column_name\":\"min_amount\",\"column_comment\":\"满减门槛金额\",\"column_type\":\"decimal\",\"default_value\":\"0.00\",\"is_pk\":1,\"is_required\":true,\"is_insert\":true,\"is_edit\":true,\"is_list\":true,\"is_query\":false,\"is_sort\":false,\"query_type\":\"eq\",\"view_type\":\"input\",\"dict_type\":null,\"allow_roles\":null,\"options\":null,\"sort\":4,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-28 14:45:25\",\"update_time\":\"2025-07-28 14:45:25\"},{\"id\":16,\"table_id\":2,\"column_name\":\"valid_days\",\"column_comment\":\"有效天数\",\"column_type\":\"int\",\"default_value\":null,\"is_pk\":1,\"is_required\":true,\"is_insert\":true,\"is_edit\":true,\"is_list\":true,\"is_query\":false,\"is_sort\":false,\"query_type\":\"eq\",\"view_type\":\"input\",\"dict_type\":null,\"allow_roles\":null,\"options\":null,\"sort\":3,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-28 14:45:25\",\"update_time\":\"2025-07-28 14:45:25\"},{\"id\":17,\"table_id\":2,\"column_name\":\"created_time\",\"column_comment\":\"创建时间\",\"column_type\":\"datetime\",\"default_value\":\"CURRENT_TIMESTAMP\",\"is_pk\":1,\"is_required\":true,\"is_insert\":false,\"is_edit\":true,\"is_list\":true,\"is_query\":false,\"is_sort\":false,\"query_type\":\"between\",\"view_type\":\"date\",\"dict_type\":null,\"allow_roles\":null,\"options\":{\"mode\":\"date\",\"showTime\":true},\"sort\":2,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-28 14:45:25\",\"update_time\":\"2025-07-28 14:45:25\"},{\"id\":18,\"table_id\":2,\"column_name\":\"updated_time\",\"column_comment\":\"更新时间\",\"column_type\":\"datetime\",\"default_value\":\"CURRENT_TIMESTAMP\",\"is_pk\":1,\"is_required\":true,\"is_insert\":false,\"is_edit\":true,\"is_list\":true,\"is_query\":false,\"is_sort\":false,\"query_type\":\"between\",\"view_type\":\"date\",\"dict_type\":null,\"allow_roles\":null,\"options\":{\"mode\":\"date\",\"showTime\":true},\"sort\":1,\"remark\":null,\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-28 14:45:25\",\"update_time\":\"2025-07-28 14:45:25\"}],\"table_name\":\"sa_coupon_template\",\"table_comment\":\"优惠券模板表\",\"stub\":\"saiadmin\",\"template\":\"app\",\"namespace\":\"CouponTemplate\",\"package_name\":\"\",\"business_name\":\"template\",\"class_name\":\"CouponTemplate\",\"menu_name\":\"优惠券模板表\",\"belong_menu_id\":0,\"tpl_category\":\"single\",\"generate_type\":1,\"generate_path\":\"saiadmin-vue\",\"generate_model\":1,\"build_menu\":1,\"component_type\":1,\"options\":{\"relations\":[]},\"form_width\":600,\"is_full\":1,\"remark\":null,\"source\":\"mysql\",\"created_by\":1,\"updated_by\":1,\"create_time\":\"2025-07-28 14:45:25\",\"update_time\":\"2025-07-28 14:45:25\"}', NULL, 1, 1, '2025-07-28 14:46:22', '2025-07-28 14:46:22', NULL);
INSERT INTO `sa_system_oper_log` VALUES (37, 'admin', 'saiadmin', 'POST', '/tool/code/generate', '未命名业务', '172.18.0.1', '内网IP', '{\"ids\":[\"2\"]}', NULL, 1, 1, '2025-07-28 14:46:26', '2025-07-28 14:46:26', NULL);

-- ----------------------------
-- Table structure for sa_system_post
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_post`;
CREATE TABLE `sa_system_post`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '岗位名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '岗位代码',
  `sort` smallint UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `status` smallint NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '岗位信息表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_post
-- ----------------------------
INSERT INTO `sa_system_post` VALUES (1, '司机岗', 'driver', 100, 1, '', 1, 1, '2025-04-27 23:34:06', '2025-04-28 11:14:44', NULL);
INSERT INTO `sa_system_post` VALUES (2, '保安岗', 'security', 100, 1, NULL, 1, 1, '2025-04-27 23:34:06', '2025-04-28 11:14:44', NULL);

-- ----------------------------
-- Table structure for sa_system_role
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_role`;
CREATE TABLE `sa_system_role`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `parent_id` int UNSIGNED NULL DEFAULT NULL COMMENT '父ID',
  `level` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '组级集合',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '角色名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '角色代码',
  `data_scope` smallint NULL DEFAULT 1 COMMENT '数据范围(1:全部数据权限 2:自定义数据权限 3:本部门数据权限 4:本部门及以下数据权限 5:本人数据权限)',
  `status` smallint NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `sort` smallint UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色信息表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_role
-- ----------------------------
INSERT INTO `sa_system_role` VALUES (1, 0, '0', '超级管理员（创始人', 'superAdmin', 1, 1, 100, '系统内置角色，不可删除', 1, 2, '2023-10-24 12:00:00', '2025-04-28 14:57:25', NULL);
INSERT INTO `sa_system_role` VALUES (2, 1, '0,1', '管理员', 'manager', 1, 1, 100, '', 1, 1, '2023-10-24 12:00:00', '2025-04-27 23:30:59', NULL);
INSERT INTO `sa_system_role` VALUES (3, 2, '0,1,2', '部门经理', 'deptManager', 1, 1, 100, '', 1, 1, '2025-04-27 23:31:44', '2025-04-28 15:47:33', NULL);
INSERT INTO `sa_system_role` VALUES (4, 2, '0,1,2', '数据管理', 'dataManager', 1, 1, 100, '', 1, 1, '2025-04-27 23:32:23', '2025-04-27 23:32:27', NULL);
INSERT INTO `sa_system_role` VALUES (5, 2, '0,1,2', '运维管理', 'operationManager', 1, 1, 100, '', 1, 2, '2025-04-27 23:33:13', '2025-04-28 14:56:03', NULL);
INSERT INTO `sa_system_role` VALUES (6, 0, '0', '附加数据接口', 'additionData', 1, 1, 100, '', 1, 2, '2025-04-28 14:18:23', '2025-04-28 15:15:11', NULL);

-- ----------------------------
-- Table structure for sa_system_role_dept
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_role_dept`;
CREATE TABLE `sa_system_role_dept`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `role_id` int UNSIGNED NOT NULL COMMENT '用户主键',
  `dept_id` int UNSIGNED NOT NULL COMMENT '角色主键',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_role_id`(`role_id` ASC) USING BTREE,
  INDEX `idx_dept_id`(`dept_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色与部门关联表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_role_dept
-- ----------------------------

-- ----------------------------
-- Table structure for sa_system_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_role_menu`;
CREATE TABLE `sa_system_role_menu`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `role_id` int UNSIGNED NOT NULL COMMENT '角色主键',
  `menu_id` int UNSIGNED NOT NULL COMMENT '菜单主键',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_role_id`(`role_id` ASC) USING BTREE,
  INDEX `idx_menu_id`(`menu_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色与菜单关联表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_role_menu
-- ----------------------------

-- ----------------------------
-- Table structure for sa_system_user
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_user`;
CREATE TABLE `sa_system_user`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID,主键',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `user_type` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '100' COMMENT '用户类型:(100系统用户)',
  `nickname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户昵称',
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '手机',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户邮箱',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户头像',
  `signed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '个人签名',
  `dashboard` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '后台首页类型',
  `dept_id` int UNSIGNED NULL DEFAULT NULL COMMENT '部门ID',
  `status` smallint NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `login_ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '最后登陆IP',
  `login_time` datetime NULL DEFAULT NULL COMMENT '最后登陆时间',
  `backend_setting` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '后台设置数据',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE,
  INDEX `dept_id`(`dept_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户信息表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_user
-- ----------------------------
INSERT INTO `sa_system_user` VALUES (1, 'admin', '$2y$10$sY/4StKVV.N/8Ock8J8kdeIOK4jS4tAUoYjkzvB8Tzy0fLh.wA2KS', '100', '祭道之上', '13888888888', 'admin@admin.com', 'https://image.saithink.top/saiadmin/avatar.jpg', 'Today is a very good day！', 'statistics', 0, 1, '172.18.0.1', '2025-07-28 16:22:58', '{\"mode\":\"light\",\"tag\":true,\"menuCollapse\":false,\"menuWidth\":230,\"layout\":\"classic\",\"skin\":\"mine\",\"i18n\":false,\"language\":\"zh_CN\",\"animation\":\"ma-slide-down\",\"color\":\"#7166F0\",\"waterMark\":false,\"waterContent\":\"saiadmin\",\"ws\":false,\"round\":true}', NULL, 1, 1, '2024-01-20 16:02:23', '2025-07-28 16:22:59', NULL);
INSERT INTO `sa_system_user` VALUES (2, 'test1', '$2y$10$Q70WC9RBqMSS72DmppsbIuQtyAydXSmeD.Ae6W8YhmE/w15uLLpiy', '100', '小小测试员', '15822222222', 'test1@saadmin.com', 'http://127.0.0.1:8787/storage/20250428/7ece61225ffe6cc374a58add56f0e8e80b03fa09.jpg', NULL, 'statistics', 2, 1, '127.0.0.1', '2025-04-29 17:04:09', 'null', 'test', 1, 1, '2024-07-31 09:34:31', '2025-04-30 13:58:56', NULL);
INSERT INTO `sa_system_user` VALUES (3, 'test2', '$2y$10$Q70WC9RBqMSS72DmppsbIuQtyAydXSmeD.Ae6W8YhmE/w15uLLpiy', '100', '酱油党', '13977777777', 'test2@saadmin.com', 'http://127.0.0.1:8787/storage/20250315/0f15984b5dad6149dca2a6b8b64b83f76863788e.png', NULL, 'work', 4, 1, '127.0.0.1', '2025-04-28 15:37:30', 'null', 'test', 1, 2, '2024-07-31 09:34:31', '2025-04-28 15:37:30', NULL);

-- ----------------------------
-- Table structure for sa_system_user_post
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_user_post`;
CREATE TABLE `sa_system_user_post`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int UNSIGNED NOT NULL COMMENT '用户主键',
  `post_id` int UNSIGNED NOT NULL COMMENT '岗位主键',
  PRIMARY KEY (`id`, `user_id`) USING BTREE,
  INDEX `idx_user_id`(`user_id` ASC) USING BTREE,
  INDEX `idx_post_id`(`post_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户与岗位关联表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_user_post
-- ----------------------------

-- ----------------------------
-- Table structure for sa_system_user_role
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_user_role`;
CREATE TABLE `sa_system_user_role`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `user_id` int UNSIGNED NOT NULL COMMENT '用户主键',
  `role_id` int UNSIGNED NOT NULL COMMENT '角色主键',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_user_id`(`user_id` ASC) USING BTREE,
  INDEX `idx_role_id`(`role_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户与角色关联表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_system_user_role
-- ----------------------------
INSERT INTO `sa_system_user_role` VALUES (1, 1, 1);

-- ----------------------------
-- Table structure for sa_tool_crontab
-- ----------------------------
DROP TABLE IF EXISTS `sa_tool_crontab`;
CREATE TABLE `sa_tool_crontab`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '任务名称',
  `type` smallint NULL DEFAULT 4 COMMENT '任务类型',
  `target` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '调用任务字符串',
  `parameter` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '调用任务参数',
  `task_style` tinyint(1) NULL DEFAULT NULL COMMENT '执行类型',
  `rule` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '任务执行表达式',
  `singleton` smallint NULL DEFAULT 1 COMMENT '是否单次执行 (1 是 2 不是)',
  `status` smallint NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '定时任务信息表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_tool_crontab
-- ----------------------------
INSERT INTO `sa_tool_crontab` VALUES (1, '访问官网', 1, 'https://saithink.top', NULL, 1, '0 0 8 * * *', 2, 1, NULL, 1, 2, '2024-01-20 14:21:11', '2025-04-29 17:54:32', NULL);
INSERT INTO `sa_tool_crontab` VALUES (2, '登录gitee', 2, 'https://gitee.com/check_user_login', '{\"user_login\": \"saiadmin\"}', 1, '0 0 10 * * *', 2, 1, NULL, 1, 1, '2024-01-20 14:31:51', '2025-04-28 00:08:34', NULL);
INSERT INTO `sa_tool_crontab` VALUES (3, '定时执行任务', 3, '\\plugin\\saiadmin\\process\\Task', '{\"type\":\"1\"}', 1, '0 30 12 * * *', 2, 1, '', 1, 1, '2024-01-20 14:38:03', '2025-04-28 00:09:30', NULL);

-- ----------------------------
-- Table structure for sa_tool_crontab_log
-- ----------------------------
DROP TABLE IF EXISTS `sa_tool_crontab_log`;
CREATE TABLE `sa_tool_crontab_log`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `crontab_id` int UNSIGNED NULL DEFAULT NULL COMMENT '任务ID',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '任务名称',
  `target` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '任务调用目标字符串',
  `parameter` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '任务调用参数',
  `exception_info` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '异常信息',
  `status` smallint NULL DEFAULT 1 COMMENT '执行状态 (1成功 2失败)',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '定时任务执行日志表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_tool_crontab_log
-- ----------------------------
INSERT INTO `sa_tool_crontab_log` VALUES (1, 2, '登录gitee', 'https://gitee.com/check_user_login', '{\"user_login\": \"saiadmin\"}', 'cURL error 28: Connection timed out after 5000 milliseconds (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://gitee.com/check_user_login', 2, '2025-06-05 10:00:09', '2025-06-05 10:00:09', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (2, 2, '登录gitee', 'https://gitee.com/check_user_login', '{\"user_login\": \"saiadmin\"}', '{\"result\":1,\"failed_count\":1}', 1, '2025-07-18 10:00:01', '2025-07-18 10:00:01', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (3, 3, '定时执行任务', '\\plugin\\saiadmin\\process\\Task', '{\"type\":\"1\"}', NULL, 1, '2025-07-18 12:30:00', '2025-07-18 12:30:00', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (4, 2, '登录gitee', 'https://gitee.com/check_user_login', '{\"user_login\": \"saiadmin\"}', '{\"result\":1,\"failed_count\":1}', 1, '2025-07-21 10:00:02', '2025-07-21 10:00:02', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (5, 3, '定时执行任务', '\\plugin\\saiadmin\\process\\Task', '{\"type\":\"1\"}', NULL, 1, '2025-07-21 12:30:00', '2025-07-21 12:30:00', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (6, 2, '登录gitee', 'https://gitee.com/check_user_login', '{\"user_login\": \"saiadmin\"}', '{\"result\":1,\"failed_count\":1}', 1, '2025-07-22 10:00:03', '2025-07-22 10:00:03', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (7, 3, '定时执行任务', '\\plugin\\saiadmin\\process\\Task', '{\"type\":\"1\"}', NULL, 1, '2025-07-22 12:30:01', '2025-07-22 12:30:01', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (8, 2, '登录gitee', 'https://gitee.com/check_user_login', '{\"user_login\": \"saiadmin\"}', '{\"result\":1,\"failed_count\":1}', 1, '2025-07-23 10:00:02', '2025-07-23 10:00:02', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (9, 3, '定时执行任务', '\\plugin\\saiadmin\\process\\Task', '{\"type\":\"1\"}', NULL, 1, '2025-07-23 12:30:01', '2025-07-23 12:30:01', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (10, 2, '登录gitee', 'https://gitee.com/check_user_login', '{\"user_login\": \"saiadmin\"}', '{\"result\":1,\"failed_count\":1}', 1, '2025-07-24 10:00:02', '2025-07-24 10:00:02', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (11, 3, '定时执行任务', '\\plugin\\saiadmin\\process\\Task', '{\"type\":\"1\"}', NULL, 1, '2025-07-24 12:30:01', '2025-07-24 12:30:01', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (12, 2, '登录gitee', 'https://gitee.com/check_user_login', '{\"user_login\": \"saiadmin\"}', '{\"result\":1,\"failed_count\":1}', 1, '2025-07-25 10:00:02', '2025-07-25 10:00:02', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (13, 3, '定时执行任务', '\\plugin\\saiadmin\\process\\Task', '{\"type\":\"1\"}', NULL, 1, '2025-07-25 12:30:01', '2025-07-25 12:30:01', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (14, 2, '登录gitee', 'https://gitee.com/check_user_login', '{\"user_login\": \"saiadmin\"}', '{\"result\":1,\"failed_count\":1}', 1, '2025-07-28 10:00:02', '2025-07-28 10:00:02', NULL);
INSERT INTO `sa_tool_crontab_log` VALUES (15, 3, '定时执行任务', '\\plugin\\saiadmin\\process\\Task', '{\"type\":\"1\"}', NULL, 1, '2025-07-28 12:30:01', '2025-07-28 12:30:01', NULL);

-- ----------------------------
-- Table structure for sa_tool_generate_columns
-- ----------------------------
DROP TABLE IF EXISTS `sa_tool_generate_columns`;
CREATE TABLE `sa_tool_generate_columns`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `table_id` int UNSIGNED NULL DEFAULT NULL COMMENT '所属表ID',
  `column_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字段名称',
  `column_comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字段注释',
  `column_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字段类型',
  `default_value` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '默认值',
  `is_pk` smallint NULL DEFAULT 1 COMMENT '1 非主键 2 主键',
  `is_required` smallint NULL DEFAULT 1 COMMENT '1 非必填 2 必填',
  `is_insert` smallint NULL DEFAULT 1 COMMENT '1 非插入字段 2 插入字段',
  `is_edit` smallint NULL DEFAULT 1 COMMENT '1 非编辑字段 2 编辑字段',
  `is_list` smallint NULL DEFAULT 1 COMMENT '1 非列表显示字段 2 列表显示字段',
  `is_query` smallint NULL DEFAULT 1 COMMENT '1 非查询字段 2 查询字段',
  `is_sort` smallint NULL DEFAULT 1 COMMENT '1 非排序 2 排序',
  `query_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'eq' COMMENT '查询方式 eq 等于, neq 不等于, gt 大于, lt 小于, like 范围',
  `view_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'text' COMMENT '页面控件,text, textarea, password, select, checkbox, radio, date, upload, ma-upload(封装的上传控件)',
  `dict_type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典类型',
  `allow_roles` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '允许查看该字段的角色',
  `options` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字段其他设置',
  `sort` tinyint UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '代码生成业务字段表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_tool_generate_columns
-- ----------------------------
INSERT INTO `sa_tool_generate_columns` VALUES (1, 1, 'id', 'ID', 'int', NULL, 2, 2, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 10, NULL, 1, 1, '2025-07-18 10:52:09', '2025-07-18 10:53:52', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (2, 1, 'type', '选项类型', 'varchar', NULL, 1, 2, 1, 1, 1, 2, 1, 'eq', 'saSelect', 'print_option_type', NULL, NULL, 9, NULL, 1, 1, '2025-07-18 10:52:09', '2025-07-18 10:53:52', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (3, 1, 'name', '选项名称', 'varchar', NULL, 1, 2, 2, 2, 2, 2, 1, 'like', 'input', NULL, NULL, NULL, 8, NULL, 1, 1, '2025-07-18 10:52:09', '2025-07-18 10:53:52', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (4, 1, 'value', '选项值', 'varchar', NULL, 1, 2, 2, 2, 2, 1, 1, 'eq', 'input', NULL, NULL, NULL, 7, NULL, 1, 1, '2025-07-18 10:52:09', '2025-07-18 10:53:52', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (5, 1, 'price', '价格', 'decimal', '0.00', 1, 2, 2, 2, 2, 1, 1, 'eq', 'input', NULL, NULL, NULL, 6, NULL, 1, 1, '2025-07-18 10:52:09', '2025-07-18 10:53:52', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (6, 1, 'sort', '排序', 'int', '0', 1, 2, 2, 2, 2, 1, 1, 'eq', 'input', NULL, NULL, NULL, 5, NULL, 1, 1, '2025-07-18 10:52:09', '2025-07-18 10:53:52', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (7, 1, 'is_default', '是否默认', 'tinyint', '0', 1, 2, 2, 2, 2, 1, 1, 'eq', 'saSelect', 'yes_or_no', NULL, NULL, 4, NULL, 1, 1, '2025-07-18 10:52:09', '2025-07-18 10:53:52', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (8, 1, 'status', '状态', 'tinyint', '0', 1, 2, 2, 2, 2, 1, 1, 'eq', 'saSelect', 'yes_no', NULL, NULL, 3, NULL, 1, 1, '2025-07-18 10:52:09', '2025-07-18 10:53:52', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (9, 1, 'create_time', '创建时间', 'datetime', NULL, 1, 1, 1, 1, 1, 2, 1, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true}', 2, NULL, 1, 1, '2025-07-18 10:52:09', '2025-07-18 10:53:52', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (10, 1, 'update_time', '更新时间', 'datetime', NULL, 1, 1, 1, 1, 1, 1, 1, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true}', 1, NULL, 1, 1, '2025-07-18 10:52:09', '2025-07-18 10:53:52', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (11, 2, 'id', '模板ID', 'bigint', NULL, 2, 2, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 8, NULL, 1, 1, '2025-07-28 14:45:25', '2025-07-28 14:46:23', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (12, 2, 'title', '优惠券标题', 'varchar', NULL, 1, 2, 2, 2, 2, 2, 1, 'like', 'input', NULL, NULL, NULL, 7, NULL, 1, 1, '2025-07-28 14:45:25', '2025-07-28 14:46:23', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (13, 2, 'type', '优惠券类型', 'tinyint', '1', 1, 2, 2, 2, 2, 2, 1, 'eq', 'input', NULL, NULL, NULL, 6, NULL, 1, 1, '2025-07-28 14:45:25', '2025-07-28 14:46:23', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (14, 2, 'amount', '优惠金额', 'decimal', '0.00', 1, 2, 2, 2, 2, 1, 1, 'eq', 'input', NULL, NULL, NULL, 5, NULL, 1, 1, '2025-07-28 14:45:25', '2025-07-28 14:46:23', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (15, 2, 'min_amount', '满减门槛金额', 'decimal', '0.00', 1, 2, 2, 2, 2, 1, 1, 'eq', 'input', NULL, NULL, NULL, 4, NULL, 1, 1, '2025-07-28 14:45:25', '2025-07-28 14:46:23', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (16, 2, 'valid_days', '有效天数', 'int', NULL, 1, 2, 2, 2, 2, 1, 1, 'eq', 'input', NULL, NULL, NULL, 3, NULL, 1, 1, '2025-07-28 14:45:25', '2025-07-28 14:46:23', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (17, 2, 'created_time', '创建时间', 'datetime', 'CURRENT_TIMESTAMP', 1, 2, 1, 2, 2, 1, 1, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true}', 2, NULL, 1, 1, '2025-07-28 14:45:25', '2025-07-28 14:46:23', NULL);
INSERT INTO `sa_tool_generate_columns` VALUES (18, 2, 'updated_time', '更新时间', 'datetime', 'CURRENT_TIMESTAMP', 1, 2, 1, 2, 2, 1, 1, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true}', 1, NULL, 1, 1, '2025-07-28 14:45:25', '2025-07-28 14:46:23', NULL);

-- ----------------------------
-- Table structure for sa_tool_generate_tables
-- ----------------------------
DROP TABLE IF EXISTS `sa_tool_generate_tables`;
CREATE TABLE `sa_tool_generate_tables`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `table_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '表名称',
  `table_comment` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '表注释',
  `stub` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'stub类型',
  `template` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '模板名称',
  `namespace` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '命名空间',
  `package_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '控制器包名',
  `business_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '业务名称',
  `class_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '类名称',
  `menu_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '生成菜单名',
  `belong_menu_id` int NULL DEFAULT NULL COMMENT '所属菜单',
  `tpl_category` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '生成类型,single 单表CRUD,tree 树表CRUD,parent_sub父子表CRUD',
  `generate_type` smallint NULL DEFAULT 1 COMMENT '1 压缩包下载 2 生成到模块',
  `generate_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'saiadmin-vue' COMMENT '前端根目录',
  `generate_model` smallint NULL DEFAULT 1 COMMENT '1 软删除 2 非软删除',
  `generate_menus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '生成菜单列表',
  `build_menu` smallint NULL DEFAULT 1 COMMENT '是否构建菜单',
  `component_type` smallint NULL DEFAULT 1 COMMENT '组件显示方式',
  `options` varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '其他业务选项',
  `form_width` int NULL DEFAULT 600 COMMENT '表单宽度',
  `is_full` tinyint(1) NULL DEFAULT 1 COMMENT '是否全屏',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '数据源',
  `created_by` int NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '代码生成业务表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_tool_generate_tables
-- ----------------------------
INSERT INTO `sa_tool_generate_tables` VALUES (1, 'sa_print_setting', '打印设置表', 'saiadmin', 'app', 'printSetting', '', 'setting', 'PrintSetting', '打印设置', 0, 'single', 1, 'saiadmin-vue', 1, 'index,save,update,read,delete', 1, 1, '{\"relations\":[]}', 600, 1, NULL, 'mysql', 1, 1, '2025-07-18 10:52:09', '2025-07-18 10:53:52', NULL);
INSERT INTO `sa_tool_generate_tables` VALUES (2, 'sa_coupon_template', '优惠券模板表', 'saiadmin', 'app', 'CouponTemplate', '', 'template', 'CouponTemplate', '优惠券模板表', 0, 'single', 1, 'saiadmin-vue', 1, 'index,save,update,read,delete', 1, 1, '{\"relations\":[]}', 600, 1, NULL, 'mysql', 1, 1, '2025-07-28 14:45:25', '2025-07-28 14:46:23', NULL);

-- ----------------------------
-- Table structure for sa_user
-- ----------------------------
DROP TABLE IF EXISTS `sa_user`;
CREATE TABLE `sa_user`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '昵称',
  `avatar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '头像',
  `mobile` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '手机号',
  `password` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `gender` tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '性别:0=未选择,1=男,2=女',
  `age` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '年龄',
  `regist_time` datetime NULL DEFAULT NULL COMMENT '注册时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '更新时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_user
-- ----------------------------
INSERT INTO `sa_user` VALUES (1, '测试用户', '', '17047868545', '$argon2id$v=19$m=65536,t=4,p=1$UUFVRkZGYWF2WFFmVzdYcQ$TDthdipEbeJSCJdsKp06X8GtYDIyzt1WatZpi7ybkdo', 0, 0, '2025-06-05 11:03:51', '2025-06-05 11:03:51', NULL);

-- ----------------------------
-- Table structure for sa_user_address
-- ----------------------------
DROP TABLE IF EXISTS `sa_user_address`;
CREATE TABLE `sa_user_address`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL COMMENT '用户ID',
  `consignee` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '收货人',
  `mobile` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系人',
  `region` json NOT NULL COMMENT '收货地址',
  `is_default` tinyint UNSIGNED NULL DEFAULT 1 COMMENT '是否默认:0=否,1=默认',
  `create_time` datetime NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `idx_id`(`id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户收货地址' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_user_address
-- ----------------------------
INSERT INTO `sa_user_address` VALUES (2, 1, '张三', '13333333325', '{\"city\": \"西安市\", \"detail\": \"龙腾路与龙首中路交叉口西北方向100米左右 宫园壹号1期\", \"district\": \"莲湖区\", \"province\": \"陕西省\"}', 0, '2025-07-28 10:11:57', '2025-07-28 14:16:16');
INSERT INTO `sa_user_address` VALUES (3, 1, '1312312', '13333333333', '{\"city\": \"西安市\", \"detail\": \"张家堡街道龙首商业街27号 夜未央创业街区\", \"district\": \"未央区\", \"province\": \"陕西省\"}', 0, '2025-07-28 10:53:15', '2025-07-28 14:15:43');
INSERT INTO `sa_user_address` VALUES (7, 1, '测试', '13312321312', '{\"city\": \"西安市\", \"detail\": \"未央路27号荣民龙首广场3层 英孚教育青少(龙首校区)\", \"district\": \"莲湖区\", \"province\": \"陕西省\"}', 0, '2025-07-28 10:57:53', '2025-07-28 10:57:53');
INSERT INTO `sa_user_address` VALUES (8, 1, '李四', '13432424242', '{\"city\": \"乌鲁木齐市\", \"detail\": \"友好南路3号 人民公园\", \"district\": \"沙依巴克区\", \"province\": \"新疆维吾尔自治区\"}', 1, '2025-07-28 14:16:42', '2025-07-28 14:21:27');

-- ----------------------------
-- Table structure for sa_user_attachment
-- ----------------------------
DROP TABLE IF EXISTS `sa_user_attachment`;
CREATE TABLE `sa_user_attachment`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NULL DEFAULT NULL COMMENT '用户ID',
  `file_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文件名',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文件地址',
  `status` tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态:0=正常,1=已使用',
  `create_time` datetime NULL DEFAULT NULL COMMENT '上传时间',
  `total` int UNSIGNED NULL DEFAULT 0 COMMENT '总页数',
  `options` json NULL COMMENT '选项',
  `selectPage` json NULL COMMENT '用户打印页数',
  `paperPrice` decimal(10, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '纸张价格',
  `totalPrice` decimal(10, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '总价',
  `copies` int UNSIGNED NULL DEFAULT 1 COMMENT '份数',
  `coverTextContent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '封面内容',
  `previceImages` json NULL COMMENT '预览图',
  `uploadImage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '封面图',
  `bookNums` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '本数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户文件表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_user_attachment
-- ----------------------------
INSERT INTO `sa_user_attachment` VALUES (13, 1, '合作后外部群标准话术_1753696878600_.pdf', '/uploads/合作后外部群标准话术_1753696878600_.pdf', 0, '2025-07-28 18:01:11', 7, '[{\"id\": 1, \"name\": \"A4\", \"type\": \"paperSize\", \"price\": \"0.00\", \"value\": \"A4\", \"max_pages\": 0}, {\"id\": 6, \"name\": \"黑白\", \"type\": \"color\", \"price\": \"0.00\", \"value\": \"black_white\", \"max_pages\": 0}, {\"id\": 10, \"name\": \"双面\", \"type\": \"side\", \"price\": \"1.00\", \"value\": \"double\", \"max_pages\": 0}, {\"id\": 12, \"name\": \"70g\", \"type\": \"paperWeight\", \"price\": \"0.00\", \"value\": \"70\", \"max_pages\": 0}, {\"id\": 14, \"name\": \"骑马钉\", \"type\": \"binding\", \"price\": \"2.00\", \"value\": \"saddle_stitch\", \"max_pages\": 60}, {\"id\": 19, \"name\": \"不缩印\", \"type\": \"multiPage\", \"price\": \"0.00\", \"value\": \"1\", \"max_pages\": 0}, {\"id\": 22, \"name\": \"深蓝\", \"type\": \"coverColor\", \"price\": \"0.00\", \"value\": \"darkBlue\", \"max_pages\": 0}, {\"id\": 23, \"name\": \"纯色封面\", \"type\": \"coverContent\", \"price\": \"0.00\", \"value\": \"plain\", \"max_pages\": 0}, {\"id\": 24, \"name\": \"护眼纸\", \"type\": \"paperType\", \"price\": \"2.00\", \"value\": \"protection\", \"max_pages\": 0}, {\"id\": 25, \"name\": \"铜版纸\", \"type\": \"coverType\", \"price\": \"2.00\", \"value\": \"coated\", \"max_pages\": 0}]', '{\"end\": 7, \"start\": 1}', 2.00, 9.00, 1, NULL, NULL, NULL, '0');

-- ----------------------------
-- Table structure for sa_user_coupon
-- ----------------------------
DROP TABLE IF EXISTS `sa_user_coupon`;
CREATE TABLE `sa_user_coupon`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NULL DEFAULT NULL COMMENT '用户',
  `coupon_id` int UNSIGNED NULL DEFAULT NULL COMMENT '优惠券ID',
  `amount` decimal(10, 2) NULL DEFAULT NULL COMMENT '金额',
  `order_id` int UNSIGNED NULL DEFAULT 0 COMMENT '使用的订单ID',
  `status` tinyint UNSIGNED NULL DEFAULT 0 COMMENT '状态:0=未使用,1=已使用',
  `create_time` datetime NULL DEFAULT NULL COMMENT '领取时间',
  `expire_time` datetime NULL DEFAULT NULL COMMENT '过期时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户优惠券' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_user_coupon
-- ----------------------------
INSERT INTO `sa_user_coupon` VALUES (2, 1, 1, 5.00, 0, 0, '2025-07-28 16:50:58', '2025-08-04 16:50:57');

-- ----------------------------
-- Table structure for sa_user_token
-- ----------------------------
DROP TABLE IF EXISTS `sa_user_token`;
CREATE TABLE `sa_user_token`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `expire_time` datetime NOT NULL COMMENT '过期时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sa_user_token
-- ----------------------------
INSERT INTO `sa_user_token` VALUES (16, 1, '2a0470c7-90a3-47b4-8e36-7c1ff0c7abe0', '2025-07-28 15:43:44', '2025-08-04 15:43:44', NULL);

SET FOREIGN_KEY_CHECKS = 1;
