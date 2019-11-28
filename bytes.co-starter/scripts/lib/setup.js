/**
 * This file exists to ENSURE that some scripts are loaded onto the site. It can 
 * also set them up in a way that makes deving and debugging easier. This should 
 * not be editted often unless you have very good reason to do so and/or would 
 * consider merging to production Bytes.co Starter.
 */

import { config } from "./../config"; // Our sites config, we'll attach to the window here.
import size from "./size"; // So we can attach to the window here for playing in the console.

/**
 * Expose for debugging purposes. DO NOT access these object through the
 * window object in other code. This is purely for console debugging and
 * playground purposes.
 */
window.BytesCo = {
  config: config,
  size: size
};

/**
 * Underscores does not export in a way that allows us to pull just this one
 * component from their package. So, we include it this way.
 */
require('./../../src/js/skip-link-focus-fix');
