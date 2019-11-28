import { config } from './../config';

const $ = jQuery;

/**
 * Helper that lets you check the viewport size in relation to
 * bootstrap breakpoints, and mobile menu breaks.
 * @type {Object}
 */
const size = {
  mobile: (config.hasOwnProperty("mainMenuBreak")) ? config.mainMenuBreak : "md",
  sizes: ["xs", "sm", "md", "lg", "xl"],
  hasCheckersOnPage: function() {
    return $("#bytesco-size-checkers").length > 0;
  },
  addCheckersToPage: function() {
    if (this.hasCheckersOnPage()) {
      return;
    }
    $("body").append(`
      <div id="bytesco-size-checkers" style="height:1px;overflow:hidden;">
        <div class="checker d-block d-sm-none" data-size="xs"></div>
        <div class="checker d-none d-sm-block d-md-none" data-size="sm"></div>
        <div class="checker d-none d-md-block d-lg-none" data-size="md"></div>
        <div class="checker d-none d-lg-block d-xl-none" data-size="lg"></div>
        <div class="checker d-none d-xl-block" data-size="xl"></div>
      </div>
    `);
  },
  getSize: function() {
    this.addCheckersToPage();
    for(var i = 0; i < this.sizes.length; i++) {
      var selector = `#bytesco-size-checkers .checker[data-size="${this.sizes[i]}"]`;
      var display = $(selector).is(":visible");
      if (display) {
        return this.sizes[i];
      }
    }
  },
  is: function(rule) {
    // Rule will be something line "<md" or ">=sm"
    // Split it into 2 parts, an operator and a size.
    var ruleRegex = rule.match(/^\s*([<>=!]*)\s*([a-z]+)\s*$/i);
    if(ruleRegex.length < 2 || typeof ruleRegex[2] == "undefined") {
      throw "Invalid syntax for calling BytesCoSize.is(rule)";
    }
    var operator = ruleRegex[1];
    var size = ruleRegex[2];
    if(operator === "") {
      return this.sizes.indexOf(this.getSize()) === this.sizes.indexOf(size);
    } else if(operator === ">") {
      return this.sizes.indexOf(this.getSize()) > this.sizes.indexOf(size);
    } else if(operator === ">=") {
      return this.sizes.indexOf(this.getSize()) >= this.sizes.indexOf(size);
    } else if(operator === "<") {
      return this.sizes.indexOf(this.getSize()) < this.sizes.indexOf(size);
    } else if(operator === "<=") {
      return this.sizes.indexOf(this.getSize()) <= this.sizes.indexOf(size);
    }
    return null;
  },
  isMobile: function() {
    return this.is(`<${this.mobile}`);
  }
};

export default size; // default becuase the name 'size' may be reserved for something else.
