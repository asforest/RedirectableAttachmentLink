<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class RedirectableAttachmentLink_Action extends Typecho_Widget implements Widget_Interface_Do
{
	public function __construct($request, $response, $params = null)
    {
        parent::__construct($request, $response, $params);

    }

    public function execute()
    {

    }

    public function action()
	{

    }
	
	public function access()
	{
        $options = Typecho_Widget::widget('Widget_Options');

        $pluginOpt = $options->plugin('RedirectableAttachmentLink');
        
        $domain = $pluginOpt->domain;

        if (!isset($this->request->acid))
        {
            throw new Typecho_Widget_Exception(_t('无效的参数'));
        }
        
        $acid = intval($this->request->get("acid"));

        
        $db = Typecho_Db::get();
        $attach = $db->fetchRow($db->select()->from('table.contents')->where('type = \'attachment\' AND cid = ?', $acid));

        if (empty($attach))
        {
            throw new Typecho_Widget_Exception(_t('文件不存在或无法读取，请与管理员联系。'));
        }

        $attach_text = unserialize($attach['text']);

        $isImage = in_array(strrchr($attach_text['name'], '.'), explode(" ", $pluginOpt->imagesuffixs));

        $attach_url = Typecho_Common::url($attach_text['path'], ($domain ? $domain : $options->index)) . ($isImage? $pluginOpt->imgstyle : "");

        $this->response->redirect($attach_url);

        // $a = ["a" => $isImage, "name" => $attach_text['name'], "q" => strrchr($attach_text['name'], '.')];

        // $this->response->throwJSON($a);
	}

}