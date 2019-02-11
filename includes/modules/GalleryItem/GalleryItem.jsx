// External Dependencies
import React, { Component } from 'react';
import {
  get,
} from 'lodash';

// Internal Dependencies
import saeUtils from '../../saeUtils';

class SaeGalleryItem extends Component {

  static slug = 'sae_gallery_item';

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
    // Module's main_css_element is not exposed to 3PS right now so manually wrap it here
    const galleryCaptionSelector = '.sae_gallery .sae_gallery_item%%order_class%% .sae-gallery-item-caption';

    // CAPTION
    // CAPTION - Background
    additionalCss = additionalCss.concat(saeUtils.generateCss(
      props,
      'background',
      'caption_background',
      galleryCaptionSelector,
      '',
      false
    ));

    // CAPTION - Margin
    additionalCss = additionalCss.concat(saeUtils.generateCss(
      props,
      'margin',
      'caption',
      galleryCaptionSelector,
      '',
      false
    ));

    // CAPTION - Padding
    additionalCss = additionalCss.concat(saeUtils.generateCss(
      props,
      'padding',
      'caption',
      galleryCaptionSelector,
      '',
      false
    ));

    return additionalCss;
  }

  /**
   * Module render in VB
   */
  render() {
    const caption = '' === get(this.props, 'caption', '') ? false : <figcaption className="sae-gallery-item-caption">
      {this.props.caption}
    </figcaption>;

    return (
      <div className="sae-gallery-item-wrapper">
        <figure>
          <div className="sae-gallery-item-image-wrapper">
            <img src={this.props.src} alt={this.props.title} />
          </div>
          {caption}
        </figure>
      </div>
    );
  }
}

export default SaeGalleryItem;
