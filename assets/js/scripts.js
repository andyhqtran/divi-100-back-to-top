jQuery(document).ready(function ($) {
  /**
   * Check if plugin class exists
   */
  if (!$('.et_divi_100_custom_back_to_top').length || !('.et_pb_scroll_top').length) {
    return false;
  }

  $('.et_pb_scroll_top').addClass('et-hidden').removeClass('et-pb-icon').html('<svg class="et-icon-arrow-up" width="11" height="7" viewBox="0 0 11 7" xmlns="http://www.w3.org/2000/svg"> <title> Arrow </title> <path d="M10.569 5.875L6.319.985a.79.79 0 0 0-.6-.27.802.802 0 0 0-.6.27L.872 5.864.8 5.948a.483.483 0 0 0-.084.272c0 .272.231.494.518.494h8.963a.507.507 0 0 0 .519-.494c0-.103-.035-.2-.09-.278l-.057-.066z" fill="#FFF" fill-rule="evenodd"/> </svg>');
});