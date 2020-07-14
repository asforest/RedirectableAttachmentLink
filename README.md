# RedirectableAttachmentLink
A plugin for Typecho Blog

本插件是为了解决附件阿里云OSS存储和本地存储之间相互转换造成的无法访问的问题,可在附件云存储和本地存储之间平滑迁移(特别是经常来回迁移的用户)
如果使用了一些数据处理服务比如阿里云的图片处理也可以在不改动文章内容的前提下切换预设处理样式

## 代码参考

1. [Typecho项目](https://github.com/typecho/typecho/blob/5ba2f03206824e33036a56bad0cf46ac318d6a77/var/Widget/Archive.php)
2. [OssForTypecho插件](https://github.com/typecho-fans/plugins/tree/master/OssForTypecho)
3. [SiteRunningTime插件](https://github.com/zhusaidong/SiteRunningTime)
4. [Access插件](https://github.com/kokororin/typecho-plugin-Access)
5. [Attachment插件](https://github.com/typecho-fans/plugins/tree/master/Attachment)


插入图片时会插入智能链接，智能链接会自动重定向到云存储或者本地存储的URL
存在于本插件安装之前的附件路径需要手动转换：每个文件依次划选住原链接，点击附件窗口中的对应文件即可完成转换
卸载本插件时需要重复一次上面的步骤以还原附件链接
本插件不会影响原有附件链接的访问
