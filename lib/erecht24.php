<?php
class rex_erecht24
{
    private static $validTypes = [
        'imprint',
        'privacyPolicy',
        'privacyPolicySocialMedia'
    ];

    /**
     * Prüft ob für die angegebene Domain und den Typ ein Text existiert
     *
     * @param int $id ID des Domain-Eintrags
     * @param string $type Art des Texts (imprint, privacy_policy, privacy_policy_social_media)
     * @param string $lang Sprache (de, en) - optional für spezifische Sprachprüfung
     * @return bool
     */
    public static function hasText(int $id, string $type, string $lang = ''): bool 
    {
        try {
            if (!in_array($type, self::$validTypes)) {
                throw new rex_exception('Invalid text type: ' . $type);
            }

            // Get domain first
            $sql = rex_sql::factory();
            $domain = $sql->setQuery(
                'SELECT domain FROM '.rex::getTable('erecht24').' WHERE id = :id',
                ['id' => $id]
            )->getValue('domain');
            
            if (!$domain) {
                return false;
            }

            // Check for text
            $sql = rex_sql::factory();
            $where = ['domain' => $domain, 'type' => $type];
            
            if ($lang) {
                // Wenn eine Sprache angegeben ist, prüfe ob der Text in dieser Sprache nicht leer ist
                $sql->setQuery(
                    'SELECT html_'.$lang.' FROM '.rex::getTable('erecht24_texts').' 
                     WHERE domain = :domain AND type = :type 
                     AND html_'.$lang.' IS NOT NULL 
                     AND html_'.$lang.' != ""',
                    $where
                );
            } else {
                // Sonst prüfe ob überhaupt ein Eintrag existiert
                $sql->setQuery(
                    'SELECT id FROM '.rex::getTable('erecht24_texts').' 
                     WHERE domain = :domain AND type = :type',
                    $where
                );
            }

            return $sql->getRows() > 0;

        } catch (Exception $e) {
            // Log error but don't expose to frontend
            rex_logger::logError(1, $e->getMessage(), __FILE__, __LINE__);
            return false;
        }
    }

    /**
     * Gibt den rechtlichen Text für die angegebene Domain/ID und den Typ zurück
     *
     * @param int $id ID des Domain-Eintrags
     * @param string $type Art des Texts (imprint, privacy_policy, privacy_policy_social_media)
     * @param string $lang Sprache (de, en)
     * @return string|null Text oder null wenn nicht gefunden
     */
    public static function getText(int $id, string $type, string $lang = 'de'): ?string 
    {
        try {
            if (!in_array($type, self::$validTypes)) {
                throw new rex_exception('Invalid text type: ' . $type);
            }

            // Get domain first
            $sql = rex_sql::factory();
            $domain = $sql->setQuery(
                'SELECT domain FROM '.rex::getTable('erecht24').' WHERE id = :id',
                ['id' => $id]
            )->getValue('domain');
            
            if (!$domain) {
                return null;
            }

            // Get text
            $html = rex_sql::factory()
                ->setQuery(
                    'SELECT html_'.$lang.' FROM '.rex::getTable('erecht24_texts').' WHERE domain = :domain AND type = :type',
                    ['domain' => $domain, 'type' => $type]
                )
                ->getValue('html_'.$lang);

            return $html ?: null;

        } catch (Exception $e) {
            rex_logger::logError(1, $e->getMessage(), __FILE__, __LINE__);
            return null;
        }
    }

    /**
     * Gibt die möglichen Text-Typen zurück
     *
     * @return array
     */
    public static function getTypes(): array
    {
        return self::$validTypes;
    }
}
