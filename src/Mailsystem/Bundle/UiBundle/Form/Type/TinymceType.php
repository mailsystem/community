<?php

namespace Mailsystem\Bundle\UiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Templating\Asset\PackageInterface;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\FormBundle\Form\DataTransformer\SanitizeHTMLTransformer;
use Oro\Bundle\FormBundle\Provider\HtmlTagProvider;

/**
 * Class TinymceType
 *
 * @package Mailsystem\Bundle\UiBundle\Form\Type
 */
class TinymceType extends AbstractType
{
    const TOOLBAR_DEFAULT = 'default';
    const TOOLBAR_SMALL = 'small';
    const TOOLBAR_LARGE = 'large';
    const TOOLBAR_FULL = 'full';

    /**
     * @var PackageInterface
     */
    protected $assetHelper;

    /**
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * @var HtmlTagProvider
     */
    protected $htmlTagProvider;

    /**
     * @var string
     */
    protected $cacheDir;

    /**
     * @url http://www.tinymce.com/wiki.php/Configuration:toolbar
     * @var array
     */
    protected $toolbars = [
        self::TOOLBAR_SMALL => [
            'undo redo | bold italic underline | bullist numlist link'
        ],
        self::TOOLBAR_DEFAULT => [
            'undo redo | bold italic underline | forecolor backcolor | bullist numlist | link | code'
        ],
        self::TOOLBAR_LARGE => [
                'undo redo | bold italic underline | forecolor backcolor | bullist numlist | link | code'
        ],
        self::TOOLBAR_FULL => [
            'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify |
            styleselect formatselect fontselect fontsizeselect | cut copy paste | bullist numlist |
            outdent indent blockquote | undo redo | link unlink anchor image media | insertdatetime preview |
            forecolor backcolor | hr removeformat | subscript superscript | table | code'
        ],
    ];

    /**
     * @param ConfigManager $configManager
     * @param HtmlTagProvider $htmlTagProvider
     * @param string $cacheDir
     */
    public function __construct(ConfigManager $configManager, HtmlTagProvider $htmlTagProvider, $cacheDir = null)
    {
        $this->configManager = $configManager;
        $this->htmlTagProvider = $htmlTagProvider;
        $this->cacheDir = $cacheDir;
    }

    /**
     * @param PackageInterface $assetHelper
     */
    public function setAssetHelper(PackageInterface $assetHelper)
    {
        $this->assetHelper = $assetHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $allowableTags = null;
        if (!empty($options['wysiwyg_options']['valid_elements'])) {
            $allowableTags = $options['wysiwyg_options']['valid_elements'];
        }

        $transformer = new SanitizeHTMLTransformer($allowableTags, $this->cacheDir);
        $builder->addModelTransformer($transformer);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $defaultWysiwygOptions = [
            'plugins' => ['textcolor', 'code', 'link', 'image', 'table', 'hr', 'preview', 'media'],
            'toolbar_type' => self::TOOLBAR_FULL,
            'skin_url' => 'bundles/oroform/css/tinymce',
            'valid_elements' => implode(',', $this->htmlTagProvider->getAllowedElements()),
            'menubar' => false,
            'statusbar' => false,
            'relative_urls' => false,
            'remove_script_host' => false,
            'convert_urls' => true,
            'width' => 850,
            'height' => 500,
        ];

        $defaults = [
            'random_id' => true,
            'wysiwyg_enabled' => (bool)$this->configManager->get('oro_form.wysiwyg_enabled'),
            'wysiwyg_options' => $defaultWysiwygOptions,
            'page-component' => [
                'module' => 'oroui/js/app/components/view-component',
                'options' => [
                    'view' => 'oroform/js/app/views/wysiwig-editor/wysiwyg-editor-view',
                    'content_css' => 'bundles/oroform/css/wysiwyg-editor.css',
                ],
            ],
        ];

        $resolver->setDefaults($defaults);
        $resolver->setNormalizers(
            [
                'wysiwyg_options' => function (Options $options, $wysiwygOptions) use ($defaultWysiwygOptions) {
                    if (empty($wysiwygOptions['toolbar_type'])
                        || !array_key_exists($wysiwygOptions['toolbar_type'], $this->toolbars)
                    ) {
                        $toolbarType = self::TOOLBAR_DEFAULT;
                    } else {
                        $toolbarType = $wysiwygOptions['toolbar_type'];
                    }
                    $wysiwygOptions['toolbar'] = $this->toolbars[$toolbarType];

                    $wysiwygOptions = array_merge($defaultWysiwygOptions, $wysiwygOptions);
                    unset($wysiwygOptions['toolbar_type']);

                    return $wysiwygOptions;
                },
                'attr' => function (Options $options, $attr) {
                    $pageComponent = $options->get('page-component');
                    $wysiwygOptions = (array)$options->get('wysiwyg_options');

                    if ($this->assetHelper) {
                        if (!empty($pageComponent['options']['content_css'])) {
                            $pageComponent['options']['content_css'] = $this->assetHelper
                                ->getUrl($pageComponent['options']['content_css']);
                        }
                        if (!empty($wysiwygOptions['skin_url'])) {
                            $wysiwygOptions['skin_url'] = $this->assetHelper->getUrl($wysiwygOptions['skin_url']);
                        }
                    }
                    $pageComponent['options'] = array_merge($pageComponent['options'], $wysiwygOptions);
                    $pageComponent['options']['enabled'] = (bool)$options->get('wysiwyg_enabled');

                    $attr['data-page-component-module'] = $pageComponent['module'];
                    $attr['data-page-component-options'] = json_encode($pageComponent['options']);

                    return $attr;
                },
            ]
        );
    }

    public function getName()
    {
        return 'tinymce';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'textarea';
    }
}
