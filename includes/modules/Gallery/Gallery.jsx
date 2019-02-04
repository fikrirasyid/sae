// External Dependencies
import React, { Component } from 'react';
import {
  includes,
} from 'lodash';

// Internal Dependencies
import saeUtils from '../../saeUtils';

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
    let additionalCss = [];

    // Selectors
    const galleryWrapperSelector = '%%order_class%% .sae-gallery-wrapper';
    const galleryItemSelector    = '%%order_class%% .sae_gallery_item';

    // GALLERY WRAPPER
    // Masonry layout style
    if ('masonry' === props.layout) {
      // GALLERY WRAPPER - Column Count
      additionalCss = additionalCss.concat(saeUtils.generateCss(
        props,
        'range',
        'column',
        galleryWrapperSelector,
        'column-count',
        true
      ));

      // GALLERY WRAPPER - Column Gap
      additionalCss = additionalCss.concat(saeUtils.generateCss(
        props,
        'range',
        'column_gutter_width',
        galleryWrapperSelector,
        'column-gap',
        true
      ));
    }


    // GALLERY ITEM
    // GALLERY ITEM - Background
    additionalCss = additionalCss.concat(saeUtils.generateCss(
      props,
      'background',
      'item_background',
      galleryItemSelector,
      '',
      false
    ));

    // GALLERY ITEM - Margin & Padding
    additionalCss = additionalCss.concat(saeUtils.generateCss(
      props,
      'margin',
      'item',
      galleryItemSelector,
      '',
      false
    ));

    additionalCss = additionalCss.concat(saeUtils.generateCss(
      props,
      'padding',
      'item',
      galleryItemSelector,
      '',
      false
    ));

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
