// External Dependencies
import React, { Component } from 'react';
import {
  includes
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
    const additionalCss = [];

    // Masonry layout style
    if ('masonry' === props.layout) {
      // Column
      additionalCss.push([{
        selector: '%%order_class%% .sae-gallery-wrapper',
        declaration: `-webkit-column-count: ${props.column};
          -moz-column-count: ${props.column};
          column-count: ${props.column};`,
      }]);

      // Column gutter width
      if ('' !== props.column_gutter_width) {
        additionalCss.push([{
          selector: '%%order_class%% .sae-gallery-wrapper',
          declaration: `-webkit-column-gap: ${props.column_gutter_width};
            -moz-column-gap: ${props.column_gutter_width};
            column-gap: ${props.column_gutter_width};`,
        }]);
      }
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
    if (includes(['grid', 'masonry'], this.props.layout)) {
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
