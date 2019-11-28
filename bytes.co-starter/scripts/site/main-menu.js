import { MenuHover } from "./../lib/menu-hover";
import { config } from "./../config";

/**
 * If enabled, make the main menu dropdowns open on hover.
 * @return {undefined}
 */
jQuery(function($) {
  const hoverMenu = new MenuHover(config.mainMenuId, config.mainMenuDelay);
  if (config.mainMenuHover) {
    hoverMenu.activate();
  }
});
