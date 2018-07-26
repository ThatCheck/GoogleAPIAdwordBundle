<?php

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Request;
use Google\AdsApi\AdWords\AdWordsSession;
use Google\AdsApi\AdWords\AdWordsSessionBuilder;
use Google\AdsApi\AdWords\Reporting\v201802\RequestOptionsFactory;
use Google\AdsApi\AdWords\ReportSettingsBuilder;
use Google\AdsApi\Common\Configuration;

/**
 * Created by PhpStorm.
 * User: KxF
 * Date: 27/12/2016
 * Time: 09:27
 */
class CustomRequestOptionFactory extends RequestOptionsFactory
{
    /**
     * Transform the old options to new options if necessary
     * @param array $options
     * @return array
     */
    static function transformOldToNewOptionsParams(array $options = array()){
        $keys = [
            'skipReportHeader' => 'isSkipReportHeader',
            'skipColumnHeader' => 'isSkipColumnHeader',
            'skipReportSummary' => 'isSkipReportSummary',
            'useRawEnumValues' => 'isUseRawEnumValues',
        ];

        $convertedOptions = array();
        foreach($keys as $key => $value){
            if(array_key_exists($key, $options) === true){
                $convertedOptions[$value] = $options[$key];
            }
        }
        return $convertedOptions;
    }

    /**
     * Provide a way to create a runtime report builder settings
     * @param AdWordsSessionBuilder $session
     * @param array $options
     * @return AdWordsSessionBuilder
     */
    static function buildRequestOptionsFactory(AdWordsSessionBuilder $session, array $options = array()){
        $arrayINI = array('ADWORDS_REPORTING' => self::transformOldToNewOptionsParams($options));
        $configuration = new Configuration($arrayINI);
        $reportSettingsBuilder = (new ReportSettingsBuilder())->from($configuration);
        if(array_key_exists('includeZeroImpressions', $options) == true){
            $reportSettingsBuilder->includeZeroImpressions($options['includeZeroImpressions']);
        }
        return $session->withReportSettings($reportSettingsBuilder->build());
    }
}