<?php
/**
 * 使用简短的附件URL在附件云存储和本地存储之间平滑迁移<br/>项目地址: <a href="https://github.com/innc11/RedirectableAttachmentLink">RedirectableAttachmentLink</a>
 *
 * @package RedirectableAttachmentLink
 * @author innc11
 * @version 1.1
 * @link https://innc11.cn
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class RedirectableAttachmentLink_Plugin implements Typecho_Plugin_Interface
{
	public static function activate()
	{
		Typecho_Plugin::factory('admin/write-post.php')->bottom = ['RedirectableAttachmentLink_Plugin','inject'];
		Typecho_Plugin::factory('admin/write-page.php')->bottom = ['RedirectableAttachmentLink_Plugin','inject'];
		
		Helper::addRoute("RAL_redirection", "/attach/[acid:digital]", "RedirectableAttachmentLink_Action", 'access');

		return _t('请打开插件设置界面进行配置');
	}

	public static function deactivate()
	{
		Helper::removeRoute("RAL_redirection");
	}

	public static function render()
	{
		
	}

	public static function personalConfig(Typecho_Widget_Helper_Form $form)
	{

	}

	public static function config(Typecho_Widget_Helper_Form $form)
	{
		$desc = new Typecho_Widget_Helper_Form_Element_Text('desc', NULL, '', _t('使用说明：'),
            _t('<ol>
					<li>本插件是为了解决附件阿里云OSS存储和本地存储之间相互转换造成的无法访问的问题(特别是经常来回迁移的用户)<br></li>
					<li>插入图片时会插入智能链接，智能链接会自动判断并重定向到云存储或者本地存储的URL<br></li>
					<li>插件安装之前的附件链接不会自动转换，进入文章编辑页面重新插入文件链接即可，卸载本插件时需要重复一次上面的步骤以还原附件链接<br></li>
					<li>本插件不会影响原有附件链接的访问<br></li>
					<li>
						代码参考：
						<a href="https://github.com/typecho/typecho/blob/5ba2f03206824e33036a56bad0cf46ac318d6a77/var/Widget/Archive.php">Typecho项目</a> | 
						<a href="https://github.com/kokororin/typecho-plugin-Access">Access插件</a> | 
						<a href="https://github.com/typecho-fans/plugins/tree/master/OssForTypecho">OssForTypecho插件</a> | 
						<a href="https://github.com/typecho-fans/plugins/tree/master/Attachment">Attachment插件</a> | 
						<a href="https://github.com/zhusaidong/SiteRunningTime">SiteRunningTime插件</a>
					</li>
				</ol>'));
		$form->addInput($desc);
		
		$domain = new Typecho_Widget_Helper_Form_Element_Text('domain', NULL, '',_t('云储存域名地址'), _t('如果附件使用云储存请填写自定义域名地址，默认留空即使用本站地址(e.g. https://xx.com)'));
		$form->addInput($domain);

		$imgstyle = new Typecho_Widget_Helper_Form_Element_Text('imgstyle', null, '', _t('分隔符+图片处理样式名：'), _t('填写<a href="https://oss.console.aliyun.com/bucket" target="_blank">Bucket设置</a>数据处理-图片处理中建立的规则名称(前面加分隔符)如-test'));
		$form->addInput($imgstyle);
		
		$imagesuffixs = new Typecho_Widget_Helper_Form_Element_Text('imagesuffixs', null, '.jpg .png .jpeg .gif .webp .bmp .svg', _t('图片后缀：'), _t('如果是图片文件会在URL后附加上图片处理样式参数. 使用空格隔开'));
        $form->addInput($imagesuffixs);

		echo '<script> window.onload = function() { document.getElementsByName("desc")[0].type = "hidden"; } </script>';
	}

	public static function inject($pageOrPost)
	{
		$options 	= Typecho_Widget::widget('Widget_Options');
		$plugin	    = $options->plugin('RedirectableAttachmentLink');

		echo '<script src="' . $options->pluginUrl . '/RedirectableAttachmentLink/js/inject.js"></script>';
	}
}