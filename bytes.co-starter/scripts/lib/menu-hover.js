import size from "./size";

const $ = jQuery;

/**
 * Accessible Bootstrap 4 navigation open/close on hover. Works by triggering
 * the default dropdown toggle, so all associated events will still apply.
 *
 * To activate, you must call activate();
 *
 * @param  {string}  menuId     The ID of the menu (the UL element);
 * @param  {integer} closeDelay The time in milliseconds its takes for the menu
 *                              to close after the user unhovers from it.
 * @return {Object}             The MenuHover object.
 */
export const MenuHover = function(menuId, closeDelay) {
  this.menuId = menuId;
  this.closeDelay = closeDelay;
  this.closeDelayTimer = null;
  this.showing = false;
};

/**
 * Activates the menu to respond to hovers.
 * @return {undefined}
 */
MenuHover.prototype.activate = function() {
  var self = this;
  $(`#${self.menuId} .nav-link.dropdown-toggle`).on('mouseenter focus', function(event) {
    self.mouseEnterFocus(event, $(this));
  });
  $(`#${self.menuId} .nav-link.dropdown-toggle`).on('mouseout focusout', function(event) {
    self.mouseOutFocusOut(event, $(this));
  });
  $('body').on('mouseenter', `#${self.menuId} .dropdown-menu.show`, function() {
    self.mouseEnterDropdown(event, $(this));
  });
  $('body').on('mouseleave', `#${self.menuId} .dropdown-menu.show`, function(event) {
    self.mouseLeaveDropdown(event, $(this));
  });
};

/**
 * Close a dropdown given the link that controls it.
 * @param  {Object} link The link that controls the dropdown to close. (jQuery)
 * @return {undefined}
 */
MenuHover.prototype.close = function(link) {
  if (size.isMobile()) return;
  // Only close the dropdown if it's open, and the user is not hovering over
  // the menu with their cursor.
  var openDropdown = link.next('.dropdown-menu.show');
  if (openDropdown.length > 0 && !openDropdown.is(':hover')) {
    link.dropdown('toggle');
  }
};

/**
 * Possibly opens the dropdown when the user enters or focuses on a link.
 * @param  {Object} event The event that triggers this function.
 * @param  {Object} link  The link that has the event happen to it. (jQuery)
 * @return {undefined}
 */
MenuHover.prototype.mouseEnterFocus = function(event, link) {
  if (size.isMobile()) return;
  // If we are opening up a dropdown (even if its just an attempt) we should
  // clear the close timer becuase we know it would have been closed already.
  clearTimeout(this.closeDelayTimer);
  if (this.showing || link.next('.dropdown-menu.show').length > 0) return;
  this.showing = true;
  link.dropdown('toggle');
};

/**
 * Possibly closes the dropdown when the user leaves or unfocuses a link.
 * @param  {Object} event The event that triggers this function.
 * @param  {Object} link  The link that has the event happen to it. (jQuery)
 * @return {undefined}
 */
MenuHover.prototype.mouseOutFocusOut = function(event, link) {
  if (size.isMobile()) return;
  var self = this;
  self.showing = false; // Lets say we are closed... even though we may not in the case of mouseout.
  if (event.type === 'mouseout') {
    link.blur();
    self.closeDelayTimer = setTimeout(function() {
      self.close(link);
    }, self.closeDelay);
  }
};

/**
 * Reset the dropdown timer if the user re-enters the dropdown.
 * @param  {Object} event    The event that triggers this function.
 * @param  {Object} dropdown The link that has the event happen to it. (jQuery)
 * @return {undefined}
 */
MenuHover.prototype.mouseEnterDropdown = function(event, dropdown) {
  if (size.isMobile()) return;
  // You could quickly hover in and out of the dropdown and it may close if the
  // timer runs up when you happen to be outside the dropdown container itself.
  clearTimeout(this.closeDelayTimer);
};

/**
 * Possibly closes the dropdown when the user leaves the dropdown.
 * @param  {Object} event    The event that triggers this function.
 * @param  {Object} dropdown The link that has the event happen to it. (jQuery)
 * @return {undefined}
 */
MenuHover.prototype.mouseLeaveDropdown = function(event, dropdown) {
  if (size.isMobile()) return;
  var self = this;
  var link = dropdown.prev('.nav-link.dropdown-toggle');
  self.closeDelayTimer = setTimeout(function() {
    self.close(link);
  }, self.closeDelay);
};
