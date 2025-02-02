<?php
$addon = rex_addon::get('erecht24');
$id = rex_request('id', 'int');

// Get domain info
$sql = rex_sql::factory();
$domain = $sql->setQuery('SELECT * FROM ' . rex::getTable('erecht24') . ' WHERE id = :id', ['id' => $id])->getArray();

if (empty($domain)) {
    echo rex_view::error($addon->i18n('domain_not_found'));
    return;
}

$domain = $domain[0];

// Get texts
$texts = rex_sql::factory()
    ->setQuery('SELECT * FROM ' . rex::getTable('erecht24_texts') . ' WHERE domain = :domain ORDER BY type ASC', ['domain' => $domain['domain']])
    ->getArray();

// Back button
$content = '<div class="btn-toolbar" style="margin-bottom: 20px;">';
$content .= '<a class="btn btn-default" href="' . rex_url::currentBackendPage(['page' => 'erecht24/settings']) . '">';
$content .= '<i class="rex-icon fa-arrow-left"></i> ' . rex_i18n::msg('back') . '</a>';
$content .= '</div>';

// Domain Info Box
$content .= '<div class="alert alert-info">';
$content .= '<h4>Domain: ' . rex_escape($domain['domain']) . ' (ID: ' . $domain['id'] . ')</h4>';
$content .= '<p class="help-block"><strong>' . $addon->i18n('code_example') . ':</strong></p>';
$content .= '<pre><code>if (rex_erecht24::hasText(' . $domain['id'] . ', \'imprint\')) {
    echo rex_erecht24::getText(' . $domain['id'] . ', \'imprint\');
}</code></pre>';
$content .= '</div>';

if (count($texts) > 0) {
    // Text Preview
    foreach ($texts as $text) {
        $content .= '<div class="panel panel-default">';
        $content .= '<header class="panel-heading"><h3 class="panel-title">' . rex_escape($text['type']) . '</h3></header>';
        $content .= '<div class="panel-body">';
        
        // Code example for this type
        $content .= '<div class="alert alert-info" style="margin-bottom: 20px;">';
        $content .= '<pre><code>echo rex_erecht24::getText(' . $domain['id'] . ', \'' . $text['type'] . '\');</code></pre>';
        $content .= '</div>';

        // Fetch date
        if ($text['last_fetch']) {
            $content .= '<p><strong>' . $addon->i18n('last_fetch') . ':</strong> ';
            $content .= rex_formatter::strftime($text['last_fetch'], 'datetime') . '</p>';
        }
        
        // German version
        $content .= '<div class="panel panel-default">';
        $content .= '<header class="panel-heading"><div class="panel-title">Deutsch</div></header>';
        $content .= '<div class="panel-body">';
        $content .= $text['html_de'];
        $content .= '</div></div>';
        
        // English version if available
        if (!empty($text['html_en'])) {
            $content .= '<div class="panel panel-default">';
            $content .= '<header class="panel-heading"><div class="panel-title">Englisch</div></header>';
            $content .= '<div class="panel-body">';
            $content .= $text['html_en'];
            $content .= '</div></div>';
        }
        
        $content .= '</div></div>';
    }
} else {
    $content .= '<div class="alert alert-warning">' . $addon->i18n('no_texts') . '</div>';
}

$fragment = new rex_fragment();
$fragment->setVar('title', $addon->i18n('preview'));
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');