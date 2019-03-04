// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import saeUtils from '../../saeUtils';

class SaeImage extends Component {

  static slug = 'sae_image';

  /**
   * Configure module styles
   *
   * @since 0.2
   *
   * @return array
   */
  static css(props) {
    let additionalCss = [];

    // Selectors
    // Module's main_css_element is not exposed to 3PS right now so manually wrap it here
    const imageCaptionSelector = '%%order_class%% .sae-image-caption';

    // CAPTION
    // CAPTION - Background
    additionalCss = additionalCss.concat(saeUtils.generateCss(
      props,
      'background',
      'caption_background',
      imageCaptionSelector,
      '',
      false
    ));

    // CAPTION - Margin
    additionalCss = additionalCss.concat(saeUtils.generateCss(
      props,
      'margin',
      'caption',
      imageCaptionSelector,
      '',
      false
    ));

    // CAPTION - Padding
    additionalCss = additionalCss.concat(saeUtils.generateCss(
      props,
      'padding',
      'caption',
      imageCaptionSelector,
      '',
      false
    ));

    return additionalCss;
  }

  /**
   * Module render in VB
   */
  render() {
    const caption = '' === this.props.content() ? false : <figcaption className="sae-image-caption">
      {this.props.content()}
    </figcaption>;

    return (
      <div className="sae-image-wrapper">
        <figure>
          <div className="sae-image-image-wrapper">
            <img src={this.props.src} alt={this.props.title} />
          </div>
          {caption}
        </figure>
      </div>
    );
  }
}

export default SaeImage;
