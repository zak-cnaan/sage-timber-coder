<?php
/**
 * The search form is rendered by `get_search_form()`. If no template is found,
 * the function will render its own search form, which is filterable. So we
 * could move this to one of the theme classes. That would do away with the last
 * of the php templates in this theme. But then again, if such a simple solution
 * is available, why not use it?
 */

$context = array();
$context['hi2'] = pll_current_language();
$context['hi3'] = pll_default_language();
$context['search_url'] = pll_default_language() == pll_current_language() ? '/':'/'.pll_current_language().'/';
Timber::render( 'blocks/searchform.twig', $context );