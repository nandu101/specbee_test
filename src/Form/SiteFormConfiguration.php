<?php

namespace Drupal\specbee_test\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Create form to save database information.
 */
class SiteFormConfiguration extends ConfigFormBase {

    /**
     * Class constructor.
     */
    public function __construct(ConfigFactoryInterface $config_factory) {
        $this->config = $config_factory;
    }

   /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'specbee_test_configuration_form';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return ['specbee_test.settings'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        // Getting the configuration value.
        $default_value = $this->config('specbee_test.settings');

        $form['specbee_test_config'] = [
            '#type' => 'fieldset',
            '#title' => $this->t('Configuration Settings Form'),
            '#weight' => 5,
            '#collapsible' => TRUE,
            '#collapsed' => FALSE,
        ];

        $form['specbee_test_config']['specbee_test_country'] = [
            '#type' => 'textfield',
            '#maxlength' => 255,
            '#default_value' => $default_value->get('specbee_test_country'),
            '#required' => TRUE,
            '#title' => $this->t('Country'),
        ];
        $form['specbee_test_config']['specbee_test_city'] = [
            '#type' => 'textfield',
            '#maxlength' => 255,
            '#default_value' => $default_value->get('specbee_test_city'),
            '#required' => TRUE,
            '#title' => $this->t('City'),
        ];
        $form['specbee_test_config']['specbee_test_timezone'] = [
            '#type' => 'select',
            '#required' => TRUE,
            '#title' => $this->t('Select Timezone'),
            '#options' => $this->getTimezoneOptions(),
            '#default_value' => $default_value->get('specbee_test_timezone'),
        ];

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {

        $this->config('specbee_test.settings')
                ->set('specbee_test_country', $form_state->getValue('specbee_test_country'))
                ->set('specbee_test_city', $form_state->getValue('specbee_test_city'))
                ->set('specbee_test_timezone', $form_state->getValue('specbee_test_timezone'))
                ->save();
        parent::submitForm($form, $form_state);
    }

    /**
     * Get Timezone options.
     */
    protected function getTimezoneOptions() {
        return array(
            '' => $this->t('-Select-'),
            'America/Chicago' => $this->t('America/Chicago'),
            'America/New_York' => $this->t('America/New_York'),
            'Asia/Tokyo' => $this->t('Asia/Tokyo'),
            'Asia/Dubai' => $this->t('Asia/Dubai'),
            'Asia/Kolkata' => $this->t('Asia/Kolkata'),
            'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
            'Europe/Oslo' => $this->t('Europe/Oslo'),
            'Europe/London' => $this->t('Europe/London'),
        );
    }

}
