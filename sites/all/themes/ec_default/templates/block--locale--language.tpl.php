<?php

/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user
 *     module is responsible for handling the default user navigation block. In
 *     that case the class would be 'block-user'.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>

<!-- LANGUAGE DROP-DOWN SECTION -->
<?php 
global $language;
$languages = language_list('enabled');
$li = "";

$li = '<li class="selected" lang="'.$language->language.'" title="'.$language->native.'"><span class="off-screen">Current language:</span> '.$language->language.'</li>';

foreach($languages[1] as $lang) {

  //get path of translated content
  $translations = translation_path_get_translations($_GET['q']);

  if ($lang->prefix) {
    if ($translations) {
      $path = $lang->prefix;
	  if(isset($translations[$lang->prefix]))
		$path .= '/'.$translations[$lang->prefix];  
    } else { // no translations for this content
      $path = ($_GET['q'] == 'node' ? $lang->prefix.'/' : $lang->prefix.'/'.$_GET['q']);
    }
  } else { //default language, no prefix
    if ($translations) {
      $path = $translations[$lang->language];
    } else { // no translations for this content
      $path = ($_GET['q'] == 'node' ? '' : $_GET['q']);
    }
  }
  //$path = ($translations ? '/'.$translations[$lang->prefix] : '');
  
  //add enabled languages
  $li .= '<li><a href="'.base_path().$path.'" hreflang="'.$lang->language.'" lang="'.$lang->language.'" title="'.$lang->native.'">'.$lang->language.'</a></li>';
}
 ?>
	<ul class="reset-list language-selector" id="language-selector">
  <?php print $li; ?>
  </ul>
<!-- LANGUAGE DROP-DOWN SECTION -->