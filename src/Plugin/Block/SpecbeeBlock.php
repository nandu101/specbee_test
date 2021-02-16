<?php

namespace Drupal\specbee_test\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\specbee_test\SiteLocationService;

/**
 * Provides 'Specbee' Block
 *
 * @Block(
 *   id = "specbee_block",
 *   admin_label = @Translation("Specbee Block"),
 *   category = @Translation("Specbee Block"),
 * )
 */
class SpecbeeBlock extends BlockBase implements ContainerFactoryPluginInterface {

    /**
     * Drupal\Core\Config\ConfigFactoryInterface definition.
     *
     * @var \Drupal\Core\Config\ConfigFactoryInterface
     */
    protected $config;
    protected $siteLocationService;

    /**
     * Constructor for this class.
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, SiteLocationService $siteLocationService) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->config = $config_factory;
        $this->siteLocationService = $siteLocationService;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
                $configuration,
                $plugin_id,
                $plugin_definition,
                $container->get('config.factory'),
                $container->get('specbee_test.current_location')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
        $res_data = $this->siteLocationService->dateTimeLocation();
        return [
            '#theme' => 'specbee-block-template',
            '#specbee_data' => $res_data,
        ];
    }

    /**
     * @return int
     */
    public function getCacheMaxAge() {
        return 0;
    }

}
