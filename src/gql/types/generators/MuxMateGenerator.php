<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   https://craftcms.github.io/license/
 */

namespace vaersaagod\muxmate\gql\types\generators;

use craft\gql\base\GeneratorInterface;
use craft\gql\GqlEntityRegistry;
use craft\gql\TypeLoader;
use GraphQL\Type\Definition\Type;
use vaersaagod\muxmate\fields\MuxMateField;
use vaersaagod\muxmate\gql\types\MuxMateType;

class MuxMateGenerator implements GeneratorInterface
{
    // Public Static methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function generateTypes(mixed $context = null): array
    {
        /** @var OptimizedImages $context */
        $typeName = self::getName($context);

        $muxMateFields = [
            // static fields
            'playbackId' => [
                'name' => 'playbackId',
                'description' => 'An string of Mux playback ID',
                'type' => Type::string(),
            ],
        ];
        $muxMateType = GqlEntityRegistry::getEntity($typeName)
            ?: GqlEntityRegistry::createEntity($typeName, new MuxMateType([
                'name' => $typeName,
                'description' => 'This entity has all the MuxMate properties',
                'fields' => function () use ($muxMateFields) {
                    return $muxMateFields;
                },
            ]));

        TypeLoader::registerType($typeName, function () use ($muxMateType) {
            return $muxMateType;
        });

        return [$muxMateType];
    }

    /**
     * @inheritdoc
     */
    public static function getName($context = null): string
    {
        return $context->handle . '_MuxMate';
    }
}
