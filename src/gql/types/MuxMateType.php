<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */


namespace vaersaagod\muxmate\gql\types;

use vaersaagod\muxmate\models\MuxMateFieldAttributes;
use vaersaagod\muxmate\helpers\MuxMateHelper;
use vaersaagod\muxmate\models\MuxPlaybackId;
use vaersaagod\muxmate\MuxMate;

use craft\gql\base\ObjectType;

use Illuminate\Support\Collection;

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
                if ($source instanceof MuxMateFieldAttributes && $source->muxMetaData) {
                    $playbackId = Collection::make($source->muxMetaData['playback_ids'] ?? [])
                        ->where('policy', MuxMate::getInstance()->getSettings()->defaultPolicy)
                        ->first();
                    
                    if (!$playbackId) {
                        return null;
                    }

                    return new MuxPlaybackId($playbackId);
                }
                return null;
                break;
            default:
                return null;
                break;
        }
    }
}
