<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */


namespace vaersaagod\muxmate\gql\types;

use vaersaagod\muxmate\models\MuxMateFieldAttributes;
use craft\gql\base\ObjectType;

use GraphQL\Type\Definition\ResolveInfo;

class MuxMateType extends ObjectType
{
    /**
     * @inheritdoc
     */
    protected function resolve(mixed $source, array $arguments, mixed $context, ResolveInfo $resolveInfo): mixed
    {
        $fieldName = $resolveInfo->fieldName;

        switch ($fieldName) {
            case 'playbackId':
                if ($source instanceof MuxMateFieldAttributes && $source->muxPlaybackId) {
                    return $source->muxPlaybackId;
                }
                return null;
                break;
            default:
                return null;
                break;
        }
    }
}
