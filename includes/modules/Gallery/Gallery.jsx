// External Dependencies
import React, { Component } from 'react';
import {
  forEach,
  get,
  includes,
  isEmpty,
  isFunction,
  set,
} from 'lodash';

class SaeGallery extends Component {

  static slug = 'sae_gallery';

  /**
   * Configure module styles
   *
   * @since ??
   *
   * @return array
   */
  static css(props) {
    // Divi Utils
    const utils = window.ET_Builder.API.Utils;

    const additionalCss = [];
    const hasCustomColumnGutterWidth = '' !== props.column_gutter_width;
    const column = parseFloat(props.column);

    // Masonry layout style
    if ('masonry' === props.layout) {
      // Column
      additionalCss.push([{
        selector: '%%order_class%% .sae-gallery-wrapper',
        declaration: `-webkit-column-count: ${column};
          -moz-column-count: ${column};
          column-count: ${column};`,
      }]);

      // Column gutter width
      if (hasCustomColumnGutterWidth) {
        additionalCss.push([{
          selector: '%%order_class%% .sae-gallery-wrapper',
          declaration: `-webkit-column-gap: ${props.column_gutter_width};
            -moz-column-gap: ${props.column_gutter_width};
            column-gap: ${props.column_gutter_width};`,
        }]);
      }
    }

    // GALLERY ITEM
    // GALLERY ITEM - Background
    const galleryItemSelector = '%%order_class%% .sae_gallery_item';
    const itemBackgroundColor = get(props, 'item_background_color');
    const itemBackgroundGradientUse  = get(props, 'item_background_use_color_gradient', 'off');
    const itemBackgroundImage = get(props, 'item_background_image');
    const itemBackgroundImages = [];

    // Gallery Item background color
    if (itemBackgroundColor) {
      additionalCss.push([{
        selector: galleryItemSelector,
        declaration: `background-color: ${itemBackgroundColor};`,
      }]);
    }

    // Prepare gallery item background gradient styles
    if ('on' === itemBackgroundGradientUse && isFunction(utils.getGradient)) {
      itemBackgroundImages.push(utils.getGradient({
        type: get(props, 'item_background_color_gradient_type'),
        direction: get(props, 'item_background_color_gradient_direction'),
        radialDirection: get(props, 'item_background_color_gradient_direction_radial'),
        colorStart: get(props, 'item_background_color_gradient_start'),
        colorEnd: get(props, 'item_background_color_gradient_end'),
        startPosition: get(props, 'item_background_color_gradient_start_position'),
        endPosition: get(props, 'item_background_color_gradient_end_position'),
      }));
    }

    // Prepare & add gallery item background image styles
    if (itemBackgroundImage) {
      itemBackgroundImages.push(`url(${itemBackgroundImage})`);

      const itemBackgroundSize = get(props, 'item_background_size');
      const itemBackgroundPosition = get(props, 'item_background_position', '');
      const itemBackgroundRepeat = get(props, 'item_background_repeat');
      const itemBackgroundBlend = get(props, 'item_background_blend');

      if (itemBackgroundSize) {
        additionalCss.push([{
          selector: galleryItemSelector,
          declaration: `background-size: ${itemBackgroundSize}`,
        }]);
      }

      if (itemBackgroundPosition) {
        additionalCss.push([{
          selector: galleryItemSelector,
          declaration: `background-position: ${itemBackgroundPosition.replace('_', ' ')}`,
        }]);
      }

      if (itemBackgroundRepeat) {
        additionalCss.push([{
          selector: galleryItemSelector,
          declaration: `background-repeat: ${itemBackgroundRepeat}`,
        }]);
      }

      if (itemBackgroundBlend) {
        additionalCss.push([{
          selector: galleryItemSelector,
          declaration: `background-blend-mode: ${itemBackgroundBlend}`,
        }]);
      }

      // Background image and gradient exist
      if (itemBackgroundImages.length > 1 && itemBackgroundBlend && 'normal' !== itemBackgroundBlend) {
        additionalCss.push([{
          selector: galleryItemSelector,
          declaration: `background-color: initial;`,
        }]);
      }
    }

    // Add gallery item background gradient and image styles (both uses background-image property)
    if (!isEmpty(itemBackgroundImages)) {
      if ('on' !== get(props, 'item_background_color_gradient_overlays_image')) {
        itemBackgroundImages.reverse();
      }

      additionalCss.push([{
        selector: galleryItemSelector,
        declaration: `background-image: ${itemBackgroundImages.join(', ')};`,
      }]);
    }

    // GALLERY ITEM - Margin & Padding
    // Check utils existence in case it isn't available
    if (isFunction(utils.getResponsiveStatus) && isFunction(utils.generateResponsiveCss)) {
      const spacingTypes               = ['margin', 'padding'];
      const spacingCorners             = ['top', 'right', 'bottom', 'left'];

      forEach(spacingTypes, spacingType => {
        const galleryItemSpacingSelector = 'margin' === spacingType ? `.et_pb_gutter .et_pb_column ${galleryItemSelector}` : galleryItemSelector;

        const itemSpacingAttrValues = {
          desktop: get(props, `item_${spacingType}`, '').split('|'),
          tablet:  get(props, `item_${spacingType}_tablet`, '').split('|'),
          phone:   get(props, `item_${spacingType}_phone`, '').split('|'),
        };

        // Check responsive status
        const isItemSpacingResponsive = utils.getResponsiveStatus(get(
          props,
          `item_${spacingType}_last_edited`,
          ''
        ));

        if (!isItemSpacingResponsive) {
          delete itemSpacingAttrValues.tablet;
          delete itemSpacingAttrValues.phone;
        }

        // Populate spacing style configuration
        const itemSpacing = {};

        forEach(itemSpacingAttrValues, (itemSpacingAttrValue, itemSpacingAttrBreakpoint) => {
          forEach(spacingCorners, (corner, cornerIndex) => {
            const spacingCorner = get(itemSpacingAttrValue, cornerIndex);

            spacingCorner && set(itemSpacing, [corner, itemSpacingAttrBreakpoint], spacingCorner);
          });
        });

        forEach(itemSpacing, (responsiveValue, corner) => {
          // Append spacing styling
          additionalCss.push(utils.generateResponsiveCss(
            responsiveValue,
            galleryItemSpacingSelector,
            `${spacingType}-${corner}`
          ));
        });
      });
    }

    return additionalCss;
  }

  /**
   * Module render in VB
   */
  render() {
    const utils = window.ET_Builder.API.Utils;

    // Wrapper classname
    const wrapperClassname = [
      'sae-gallery-wrapper',
      `sae-gallery-layout-${this.props.layout}`,
    ];

    // Wrapper data attributes
    const wrapperDataAttrs = {};

    // Column classnames & data attribute
    if (includes(['masonry'], this.props.layout)) {
      wrapperClassname.push(`sae-gallery-column-${this.props.column}`);

      wrapperDataAttrs['data-sae-column'] = this.props.column;
    }

    return (
      <div className={utils.classnames(wrapperClassname)} {...wrapperDataAttrs}>
        {this.props.content}
      </div>
    );
  }
}

export default SaeGallery;
