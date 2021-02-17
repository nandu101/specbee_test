<?php

namespace Drupal\specbee_test;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * @file providing the service that current time 'given timezone'.
 *
 */
class SiteLocationService {

   /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   * Constructor for this class.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config = $config_factory;
  }

    /**
     * {@inheritdoc}
     */
    public function dateTimeLocation() {
        $specbee_config = $this->config->get('specbee_test.settings');
        $timezone = $specbee_config->get('specbee_test_timezone');
        $country = $specbee_config->get('specbee_test_country');
        $city = $specbee_config->get('specbee_test_city');

        $date = new DrupalDateTime("now");
        $date->setTimezone(new \DateTimeZone($timezone));
        $date_time = $date->format('d\t\h M Y - g:i A');
        $res = array(
            'country' => $country,
            'city' => $city,
            'timezone' => $timezone,
            'date' => $date_time
        );
        return $res;
    }

}
