<?php

namespace Mailsystem\Bundle\RecipientBundle\ImportExport\Serializer\Normalizer;

use Oro\Bundle\ImportExportBundle\Serializer\Normalizer\ConfigurableEntityNormalizer;

use Mailsystem\Bundle\RecipientBundle\Entity\Recipient;

/**
 * Class RecipientNormalizer
 * @package Mailsystem\Bundle\RecipientBundle\ImportExport\Serializer\Normalizer
 */
class RecipientNormalizer extends ConfigurableEntityNormalizer
{
    public function normalize($object, $format = null, array $context = array())
    {
        $result = parent::normalize($object, $format, $context);

        if (isset($result['organization_id'])) {
            unset($result['organization_id']);
        }

        if (isset($result['user_owner_id'])) {
            unset($result['user_owner_id']);
        }

        return $result;
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (isset($data['organization_id'])) {
            unset($data['organization_id']);
        }
        if (isset($data['user_owner_id'])) {
            unset($data['user_owner_id']);
        }

        return parent::denormalize($data, $class, $format, $context);
    }

    public function supportsNormalization($data, $format = null, array $context = array())
    {
        return $data instanceof Recipient;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = array())
    {
        return is_array($data) && $type == 'Mailsystem\Bundle\RecipientBundle\Entity\Recipient';
    }
}
