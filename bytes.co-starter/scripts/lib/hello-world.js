import { config } from "./../config";

/**
 * This is and example module that exports a function.
 * @param  {String} name The name of the person to welcome.
 * @return {undefined}
 */
export function helloWorld(name) {
  const message = `Welcome, ${name}. You are running the theme "${config.themeName}"`;
  console.warn(message);
}
