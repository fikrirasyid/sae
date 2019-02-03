// External dependencies
import {
  assign,
  forEach,
  get,
  isEmpty,
  isObject,
  isString,
  pickBy,
} from 'lodash';

// Utilities
const saeUtils = {
  /**
   * Generate responsive CSS declaration
   *
   * @since ??
   *
   * @param {Object} responsiveValues         CSS property & values in various breakpoints
   * @param {Object} responsiveValues.desktop CSS property & value for desktop breakpoint in
   *                                          {propertyName: propertyValue} structure
   * @param {Object} responsiveValues.tablet  CSS property & value for tablet breakpoint in
   *                                          {propertyName: propertyValue} structure
   * @param {Object} responsiveValues.phone   CSS property value for phone breakpoint in
   *                                          {propertyName: propertyValue} structure
   * @param {string} selector                 CSS selector
   * @param {boolean} addBrowserPrefixVersion Automatically generates -webkit-* & -moz- prefixed
   *                                          version of given CSS property
   */
  generateResponsiveCss(responsiveValues, selector, addBrowserPrefixVersion = false) {
    if (!isObject(responsiveValues)) {
      return [];
    }

    const responsiveCss = [];

    // Loop and populate responsive CSS settings
    forEach(responsiveValues, (value, device) => {
      if (!isObject(value) && !isEmpty(value)) {
        return;
      }

      const declaration = [];

      forEach(value, (propertyValue, property) => {
        if (addBrowserPrefixVersion) {
          declaration.push(`-webkit-${property}:${propertyValue};`);
          declaration.push(`-moz-${property}:${propertyValue};`);
        }

        declaration.push(`${property}:${propertyValue};`);
      });

      const breakpointCss = {
        selector:    selector,
        declaration: declaration.join(''),
        device:      device,
      };

      responsiveCss.push(breakpointCss);
    });

    return responsiveCss;
  },
  /**
   * Generate gradient color declaration based on gradient argument given
   *
   * @see https://developer.mozilla.org/en-US/docs/Web/CSS/gradient
   *
   * @since ??
   *
   * @param {Object} args                 gradient arguments
   * @param {string} args.type            linear|radial gradient type
   * @param {string} args.direction       gradient direction if type = linear
   * @param {string} args.radialDirection gradient direction if type = radial
   * @param {string} args.colorStart      color start (hexacode, rgb(a))
   * @param {string} args.colorEnd        color end (hexacode, rgb(a))
   * @param {string} args.startPosition   gradient start position (1-100, in % unit)
   * @param {string} args.endPosition     gradient end position (1-100, in % unit)
   *
   * @return {string}
   */
  generateGradientDeclaration(args) {
    // Gradient defaults
    const defaults      = window.ETBuilderBackend.defaults.backgroundOptions;
    const defaultArgs   = {
      type: defaults.type,
      direction: defaults.direction,
      radialDirection: defaults.radialDirection,
      colorStart: defaults.colorStart,
      colorEnd: defaults.colorEnd,
      startPosition: defaults.startPosition,
      endPosition: defaults.endPosition,
    };

    // Translate gradient type into CSS declaration
    const direction     = args.type === 'linear' ? args.direction : `circle at ${args.radialDirection}`;

    // Parse custom arguments against default value
    const settings      = assign(defaultArgs, pickBy(args, value => (value)));

    // Return gradient (formatted as CSS property value for background-image property)
    return `${settings.type}-gradient(
      ${direction},
      ${settings.colorStart} ${settings.startPosition},
      ${settings.colorEnd} ${settings.endPosition}
    )`;
  },
  /*
   * Evaluate field responsive status by evaluating *_last_edited attribute value
   *
   * @since ??
   *
   * @param {string} lastEdited *_last_edited attribute value
   *
   * @return {boolean}
   */
  isFieldResponsive(lastEdited = '') {
    const lastEditedArray = isString(lastEdited) ? lastEdited.split('|') : ['on', 'desktop'];

    return 'on' === get(lastEditedArray, 0, 'off');
  },
};

const {
  generateResponsiveCss,
  generateGradientDeclaration,
  isFieldResponsive,
} = saeUtils;

export {
  generateResponsiveCss,
  generateGradientDeclaration,
  isFieldResponsive,
};

export default saeUtils;