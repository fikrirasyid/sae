// External dependencies
import {
  assign,
  forEach,
  get,
  isEmpty,
  isObject,
  isString,
  pickBy,
  set,
} from 'lodash';

// Utilities
const saeUtils = {
  /**
   * Automatically process fields data into CSS settings
   *
   * @since ??
   *
   * @param {object}  props              module props
   * @param {string}  fieldType          field type
   * @param {string}  baseAttrName       base attribute name used by the field
   * @param {string}  selector           css selector
   * @param {string}  cssProperty        css property used by the field (fieldType = range)
   * @param {boolean} addBrowserProperty add browser specific vendor css property
   *
   * @return {array} array of css settings
   */
  generateCss(props, fieldType, baseAttrName, selector, cssProperty, addBrowserProperty = false) {
    let additionalCss = [];

    switch(fieldType) {
      case 'range':
        const lastEdited   = get(props, `${baseAttrName}_last_edited`, '');
        const isResponsive = this.isFieldResponsive(lastEdited);
        const desktopValue = get(props, baseAttrName);

        const fieldCss     = !isResponsive ? [{
          selector: selector,
          declaration: !addBrowserProperty ?
            `${cssProperty}}: ${desktopValue};`
            :
            `-webkit-${cssProperty}: ${desktopValue};
            -moz-${cssProperty}: ${desktopValue};
            ${cssProperty}}: ${desktopValue};`,
          }] : this.generateResponsiveCss(
          {
            desktop: {[cssProperty]: desktopValue},
            tablet:  {[cssProperty]: get(props, `${baseAttrName}_tablet`)},
            phone:   {[cssProperty]: get(props, `${baseAttrName}_phone`)}
          },
          selector,
          addBrowserProperty
        );

        additionalCss.push(fieldCss);
        break;
      case 'background':
        const backgroundColor = get(props, `${baseAttrName}_color`);
        const backgroundGradientUse  = get(props, `${baseAttrName}_use_color_gradient`, 'off');
        const backgroundImage = get(props, `${baseAttrName}_image`);
        const backgroundImages = [];

        // Gallery Item background color
        if (backgroundColor) {
          additionalCss.push([{
            selector: selector,
            declaration: `background-color: ${backgroundColor};`,
          }]);
        }

        // Prepare gallery item background gradient styles
        if ('on' === backgroundGradientUse) {
          backgroundImages.push(saeUtils.generateGradientDeclaration({
            type: get(props, `${baseAttrName}_color_gradient_type`),
            direction: get(props, `${baseAttrName}_color_gradient_direction`),
            radialDirection: get(props, `${baseAttrName}_color_gradient_direction_radial`),
            colorStart: get(props, `${baseAttrName}_color_gradient_start`),
            colorEnd: get(props, `${baseAttrName}_color_gradient_end`),
            startPosition: get(props, `${baseAttrName}_color_gradient_start_position`),
            endPosition: get(props, `${baseAttrName}_color_gradient_end_position`),
          }));
        }

        // Prepare & add gallery item background image styles
        if (backgroundImage) {
          backgroundImages.push(`url(${backgroundImage})`);

          const backgroundSize = get(props, `${baseAttrName}_size`);
          const backgroundPosition = get(props, `${baseAttrName}_position`, '');
          const backgroundRepeat = get(props, `${baseAttrName}_repeat`);
          const backgroundBlend = get(props, `${baseAttrName}_blend`);

          if (backgroundSize) {
            additionalCss.push([{
              selector: selector,
              declaration: `background-size: ${backgroundSize}`,
            }]);
          }

          if (backgroundPosition) {
            additionalCss.push([{
              selector: selector,
              declaration: `background-position: ${backgroundPosition.replace('_', ' ')}`,
            }]);
          }

          if (backgroundRepeat) {
            additionalCss.push([{
              selector: selector,
              declaration: `background-repeat: ${backgroundRepeat}`,
            }]);
          }

          if (backgroundBlend) {
            additionalCss.push([{
              selector: selector,
              declaration: `background-blend-mode: ${backgroundBlend}`,
            }]);
          }

          // Background image and gradient exist
          if (backgroundImages.length > 1 && backgroundBlend && 'normal' !== backgroundBlend) {
            additionalCss.push([{
              selector: selector,
              declaration: `background-color: initial;`,
            }]);
          }
        }

        // Add gallery item background gradient and image styles (both uses background-image property)
        if (!isEmpty(backgroundImages)) {
          if ('on' !== get(props, `${baseAttrName}_color_gradient_overlays_image`)) {
            backgroundImages.reverse();
          }

          additionalCss.push([{
            selector: selector,
            declaration: `background-image: ${backgroundImages.join(', ')};`,
          }]);
        }
        break;
      case 'margin':
      case 'padding':

        const spacingCorners  = ['top', 'right', 'bottom', 'left'];
        const spacingSelector = 'margin' === fieldType ?
          `.et_pb_gutter .et_pb_column ${selector}` :
          selector;

        const spacingAttrValues = {
          desktop: get(props, `${baseAttrName}_${fieldType}`, '').split('|'),
          tablet:  get(props, `${baseAttrName}_${fieldType}_tablet`, '').split('|'),
          phone:   get(props, `${baseAttrName}_${fieldType}_phone`, '').split('|'),
        };

        // Check responsive status
        const isSpacingResponsive = saeUtils.isFieldResponsive(get(
          props,
          `${baseAttrName}_${fieldType}_last_edited`,
          ''
        ));

        if (!isSpacingResponsive) {
          delete spacingAttrValues.tablet;
          delete spacingAttrValues.phone;
        }

        // Populate spacing style configuration
        const spacing = {};

        forEach(spacingAttrValues, (spacingAttrValue, spacingAttrBreakpoint) => {
          forEach(spacingCorners, (corner, cornerIndex) => {
            const spacingCorner = get(spacingAttrValue, cornerIndex);

            // Populate spacing responsive styles
            spacingCorner && set(
              spacing,
              [spacingAttrBreakpoint, `${fieldType}-${corner}`],
              spacingCorner
            );
          });
        });

        // Append spacing styling
        additionalCss.push(saeUtils.generateResponsiveCss(
          spacing,
          spacingSelector,
        ));

        break;
      default:
        break;

    }

    return additionalCss;
  },

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
  generateCss,
  generateResponsiveCss,
  generateGradientDeclaration,
  isFieldResponsive,
} = saeUtils;

export {
  generateCss,
  generateResponsiveCss,
  generateGradientDeclaration,
  isFieldResponsive,
};

export default saeUtils;