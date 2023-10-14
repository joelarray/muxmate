<?php

namespace vaersaagod\muxmate\models;

use craft\base\Model;
use craft\helpers\App;

use vaersaagod\muxmate\MuxMate;

/**
 * MuxMate settings
 */
class Settings extends Model
{

    public ?string $muxAccessTokenId = null;

    public ?string $muxSecretKey = null;

    public ?MuxSigningKey $muxSigningKey = null;

    public string|bool|null $muxPlayerUrl = null;

    public string|bool|null $muxVideoUrl = null;

    public string $defaultPolicy = 'public';

    public string $defaultMp4Quality = 'high';

    public bool $lazyloadMuxVideo = false;

    public ?string $scriptSrcNonce = null;

    public ?array $volumes = null;

    public function setAttributes($values, $safeOnly = true): void
    {
        $values['muxPlayerUrl'] = $values['muxPlayerUrl'] ?? null;
        if ($values['muxPlayerUrl'] !== false) {
            $values['muxPlayerUrl'] = App::parseEnv($values['muxPlayerUrl']) ?: MuxMate::MUX_PLAYER_URL;
        }
        $values['muxVideoUrl'] = $values['muxVideoUrl'] ?? null;
        if ($values['muxVideoUrl'] !== false) {
            $values['muxVideoUrl'] = App::parseEnv($values['muxVideoUrl']) ?: MuxMate::MUX_VIDEO_URL;
        }
        if (!empty($values['muxSigningKey'])) {
            $values['muxSigningKey'] = new MuxSigningKey([
                'id' => $values['muxSigningKey']['id'] ?? null,
                'privateKey' => $values['muxSigningKey']['privateKey'] ?? null,
            ]);
        }
        if (array_key_exists('defaultPolicy', $values) && empty($values['defaultPolicy'])) {
            unset($values['defaultPolicy']);
        }
        if (array_key_exists('defaultMp4Quality', $values) && empty($values['defaultMp4Quality'])) {
            unset($values['defaultMp4Quality']);
        }
        parent::setAttributes($values, $safeOnly);
    }

}
