<?php

namespace Drupal\specbee_test;

use Drupal;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * @file providing the service that current time 'given timezone'.
 *
 */
class SiteLocationService {

    public function dateTimeLocation() {

        $timezone = $this->getConfig('specbee_test_timezone');
        $date = new DrupalDateTime("now");
        $date->setTimezone(new \DateTimeZone($timezone));
        $date_time = $date->format('d\t\h M Y - g:i A');
        $res = array(
            'country' => $this->getConfig('specbee_test_country'),
            'city' => $this->getConfig('specbee_test_city'),
            'timezone' => $timezone,
            'date' => $date_time
        );
        return $res;
    }

    /**
     * Return form setting value.
     */
    public function getConfig($config) {
        return Drupal::config('specbee_test.settings')->get($config);
    }

}
