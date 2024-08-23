<?php

declare(strict_types=1);

//Add whatever options here. The CURLOPT_URL is left out intentionally.
//It will be added in later from the url array.
//$optionArray = [
//    CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0',
// Pick your user agent.
//    CURLOPT_RETURNTRANSFER => true,
//    CURLOPT_TIMEOUT        => 10,
//    CURLOPT_ENCODING       => 'UTF-8',
//    CURLOPT_MAXREDIRS      => 10,
//    CURLOPT_FOLLOWLOCATION => true,
//    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
//    CURLOPT_CUSTOMREQUEST  => 'GET',
//];

////Play around with this number and see what works best.
////This is how many urls it will try to do at one time.
//$nThreads = numCpus();

if (! function_exists('multi_thread_curl')) {
    /**
     * @param array $urlArray
     * @return array
     */
    function multi_thread_curl(array $urlArray = [], int $nThreads = 1, bool $preserveKeys = true): array
    {
        //Group your urls into groups/threads.
        $curlArray = array_chunk($urlArray, $nThreads, $preserveKeys);

        //Iterate through each batch of urls.
        $ch = 'ch_';
        foreach ($curlArray as $threads) {
            //Create your cURL resources.
            foreach ($threads as $thread => $value) {
                ${$ch . $thread} = curl_init();

                curl_setopt_array(${$ch . $thread}, $value['options']); //Set your main curl options.
                curl_setopt(${$ch . $thread}, CURLOPT_URL, $value['url']); //Set url.
            }

            //Create the multiple cURL handler.
            $mh = curl_multi_init();

            //Add the handles.
            foreach ($threads as $thread => $value) {
                curl_multi_add_handle($mh, ${$ch . $thread});
            }

            $active = null;

            //execute the handles.
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc === CURLM_CALL_MULTI_PERFORM);

            while ($active && $mrc === CURLM_OK) {
                if (curl_multi_select($mh) !== -1) {
                    do {
                        $mrc = curl_multi_exec($mh, $active);
                    } while ($mrc === CURLM_CALL_MULTI_PERFORM);
                }
            }

            //Get your data and close the handles.
            foreach ($threads as $thread => $value) {
                $results[$thread] = curl_multi_getcontent(${$ch . $thread});
                curl_multi_remove_handle($mh, ${$ch . $thread});
            }

            //Close the multi handle exec.
            curl_multi_close($mh);
        }

        return $results;
    }
}
