<?php

if (! function_exists('domain_btn')) {
    
    function domain_btn($domain)
    {
        $prefix = '';
        $btns = [
            [
            'display'=>'Settings',
            'route'=>route($prefix . 'domains.edit', $domain->id),
            'icon'=>'fa fa-cog',
            'color'=>'btn-primary',
            ],
            [
            'display'=>'Emails',
            'hide' =>true,
            'route'=>route($prefix . 'domains.email_boxes.index', $domain->id),
            'icon'=>'fa fa-envelope-o',
            ],
            /*[
            'display'=>'Email Boxes',
            'hide' =>true,
            'route'=>route($prefix . 'domains.email_boxes.index', $this),
            'icon'=>'fa fa-envelope',
            ],*/
            [
            'display'=>'Hosting',
            'hide' =>true,
            'route'=>route($prefix . 'domains.hosting.index', $domain->id),
            'icon'=>'fa fa-hdd-o',
            ],
            /*[
            'display'=>'DNS',
            'hide' =>true,
            'route'=>route($prefix . 'domains.dns.index', $this),
            'icon'=>'fa fa-server',
            ],*/
            [
            'display'=>'Advanced',
            'hide' =>true,
            'route'=>route($prefix . 'domains.advanced.lock', $domain->id),
            'icon'=>'fa fa-code',
            ],
        ];
        return $btns;
    }
}

if (!function_exists('removeAllInstancesOfTag')) {
    function removeAllInstancesOfTag($html, $tag_nm) {

        if (!empty($html)) {
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'); /* For UTF-8 Compatibility. */
            $doc = new DOMDocument();
            $doc->loadHTML($html,LIBXML_HTML_NOIMPLIED|LIBXML_HTML_NODEFDTD|LIBXML_NOWARNING);

            if (!empty($tag_nm)) {
                if (is_array($tag_nm)) {

                    $tag_nms = $tag_nm;
                    unset($tag_nm);

                    foreach ($tag_nms as $tag_nm)
                    {
                        $rmvbl_itms = $doc->getElementsByTagName(strval($tag_nm));
                        $rmvbl_itms_arr = [];

                        foreach ($rmvbl_itms as $itm)
                        {
                            $rmvbl_itms_arr[] = $itm;
                        }

                        foreach ($rmvbl_itms_arr as $itm)
                        {
                            $itm->parentNode->removeChild($itm);
                        }
                    }
                } else if (is_string($tag_nm)) {
                    $rmvbl_itms = $doc->getElementsByTagName($tag_nm);
                    $rmvbl_itms_arr = [];

                    foreach ($rmvbl_itms as $itm)
                    {
                        $rmvbl_itms_arr[] = $itm;
                    }

                    foreach ($rmvbl_itms_arr as $itm)
                    {
                        $itm->parentNode->removeChild($itm); 
                    }
                }
            }

            return $doc->saveHTML();
        } else {
            return '';
        }
    }
};

/* Remove all instances of a particular HTML tag (e.g. <script>...</script>) from a variable containing raw HTML data. [END] */

/* Remove all instances of dangerous and pesky <script> tags from a variable containing raw user-input HTML data. [BEGIN] */

/* Prerequisites: 'removeAllInstancesOfTag(...)' */

if (!function_exists('removeAllScriptTags'))
{
    function removeAllScriptTags($html)
    {
        return removeAllInstancesOfTag($html, 'script');
    };
};
