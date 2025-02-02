# Legal text model
Legal texts will be created and managed using the [eRecht24 Projekt Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/).
With this *eRecht24 Rechtstexte-SDK* you are now able to import those texts.

## Properties
```php
/**
 * @class eRecht24\RechtstexteSDK\Model\LegalText
 * 
 * @property string type            // client text type
 *
 * @property string html_de         // german version of legal text 
 * @property string html_en         // english version of legal text
 * @property string warnings        // warnings
 * @property string pushed          // last client pushed date
 * @property string created         // client creation date
 * @property string modified        // last client updated date
 */
```

## Receiving attribute values
There are common methods for getting the relevant text attributes:

```php
    /**
     * @return null|string
     */
    public function getType(): ?string;

    /**
     * Get the html text by language
     * default: en
     *  
     * @param string $lang
     * @return string|null
     */
    public function getHtml(string $lang = 'en'): ?string;

    /**
     * Get the EN html text
     *  
     * @return string|null
     */
    public function getHtmlEN(): ?string;

    /**
     * Get the DE html text
     *  
     * @return string|null
     */
    public function getHtmlDE(): ?string;

    /**
     * @return string|null
     */
    public function getWarnings(): ?string;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @return string|null
     */
    public function getModifiedAt(): ?string;

```

## Types
There are 3 different types of legal text right now.

### Imprint
The base class for the common imprint document.
```php
/**
 * @class eRecht24\RechtstexteSDK\Model\LegalText\Imprint
 */
class Imprint extends LegalText
{
    const PUSH_ID = 'imprint';

    /**
     * @var string
     */
    protected $type = 'imprint';
}
```

### Privacy policy
The base class for the common privacy policy.
```php
/**
 * @class eRecht24\RechtstexteSDK\Model\LegalText\PrivacyPolicy
 */
class PrivacyPolicy extends LegalText
{
    const PUSH_ID = 'privacyPolicy';

    /**
     * @var string
     */
    protected $type = 'privacy_policy';
}
```

### Privacy policy social media
The base class for the privacy policy in the context of social media.
```php
/**
 * @class eRecht24\RechtstexteSDK\Model\LegalText\PrivacyPolicySocialMedia
 */
class PrivacyPolicySocialMedia extends LegalText
{
    const PUSH_ID = 'privacyPolicySocialMedia';

    /**
     * @var string
     */
    protected $type = 'privacy_policy_social_media';
}
```
**Note** :The classes are for extensions. There may be document specific modifications in the future.

## Legal text wrapper class
The class reflects all types of legal text documents. That way it is easy to 
```php
use eRecht24\RechtstexteSDK\Helper\Helper;
use \eRecht24\RechtstexteSDK\Model\LegalText;
use \eRecht24\RechtstexteSDK\LegalTextHandler;

    { ... }

    switch ($documentType) {
        case Helper::PUSH_TYPE_IMPRINT:
        case Helper::PUSH_TYPE_PRIVACY_POLICY:
        case Helper::PUSH_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA:
            $docWrapper = new LegalTextHandler('YOUR_API_KEY', $documentType, 'YOUR-PLUGIN-KEY');
            /* @var LegalText $legalText */
            $legalText = $docWrapper->importDocument();
            return;
    }

    { ... }
```
