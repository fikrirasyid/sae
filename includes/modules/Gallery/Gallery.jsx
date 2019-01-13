// External Dependencies
import React, { Component } from 'react';

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
    const utils         = window.ET_Builder.API.Utils;
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
    }

    return additionalCss;
  }

  /**
   * Module render in VB
   */
  render() {
    return (
      <div className="sae-gallery-wrapper">
        {this.props.content}
      </div>
    );
  }
}

export default SaeGallery;
