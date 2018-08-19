<?php

class extension_page_headers extends Extension
{
    private $headersTrigger;

    /**
     * INSTALL
     *
     * http://www.getsymphony.com/learn/api/2.3/toolkit/extension/#install
     *
     * @since version 1.0.0
     */

    public function install()
    {
        return true;
    }

    /**
     * UNINSTALL
     *
     * http://www.getsymphony.com/learn/api/2.3/toolkit/extension/#uninstall
     *
     * @since version 1.0.0
     */

    public function uninstall()
    {
        return true;
    }

    /**
     * GET SUBSCRIBED DELEGATES
     *
     * https://www.getsymphony.com/learn/api/2.3/toolkit/extension/#getSubscribedDelegates
     * https://www.getsymphony.com/learn/api/2.3/delegates/#FrontendPageResolved
     * https://www.getsymphony.com/learn/api/2.3/delegates/#FrontendOutputPostGenerate
     *
     * @since version 1.0.0
     */

    public function getSubscribedDelegates()
    {
        return array(
            array(
                'page'		=> '/frontend/',
                'delegate'	=> 'FrontendPageResolved',
                'callback'	=> 'checkHeadersPageType'
                ),
            array(
                'page'		=> '/frontend/',
                'delegate'	=> 'FrontendOutputPostGenerate',
                'callback'	=> 'processPageContent'
            )
        );
    }

    /**
     * CHECK HEADERS PAGE TYPES
     *
     * @since version 1.0.0
     */

    public function checkheadersPageType($page)
    {
        //Check that the page type has been sent to 'headers' so we only process a page when we need to
        if (is_array($page) &&
            is_array($page['page_data']) &&
            array_key_exists('type', $page['page_data']) &&
            array_search('headers',$page['page_data']['type']) !== false
        ) {
            $this->headersTrigger = true;
        }
    }

    /**
     * PROCESS PAGE CONTENT
     *
     * @since version 1.0.0
     */

    public function processPageContent($page)
    {
        //If this page has 'headers' set as a page type, process the content.
        if ($this->headersTrigger === true) {

            $content = $page['output'];

            if (
                //If the content is false that means there is likely a symphony error being shown. If so, don't do anything. 
                $content !== false &&

                //Just check that the page content doesn't start with an angle bracket, as that would mean XML/HTML was probably being output and not the sweet juicy headers we crave.
                strpos($content, '<') !== 0 && 

                //Check we haven't already sent the headers, to avoid nasty PHP error.
                !headers_sent()

            ) {

                //split response by two consecutive newlines (as per http sepc)
                $parts = explode("\n\n", $content);

                //grab the block before the first two newlines, and then split by newlines for each header
                $headers = explode("\n",array_shift($parts));

                if (is_array($headers)) {

                    //Send each found header
                    foreach ($headers as $header) {
                        header(trim($header));
                    }

                    //Turn parts back into string, with headers absent due to array_unshift above
                    $page['output'] = trim(implode("\n", $parts));

                    //If only headers were used in the page output, kill the script now, as we have nothing else to send, and a Symphony error will be generated if the output is empty.
                    if (strlen($page['output']) === 0) die();
                }
            }
        }
    }

}