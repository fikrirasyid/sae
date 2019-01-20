// External Dependencies
import React, { Component } from 'react';
import {
  get,
} from 'lodash';


class SaeGalleryItem extends Component {

  static slug = 'sae_gallery_item';

  /**
   * Module render in VB
   */
  render() {
    const caption = '' === get(this.props.content(), 'props.content') ? false : <div className="sae-gallery-item-caption">
      {this.props.content()}
    </div>;

    return (
      <div className="sae-gallery-item-wrapper">
        <div className="sae-gallery-item-image-wrapper">
          <img src={this.props.src} alt={this.props.title} />
        </div>
        {caption}
      </div>
    );
  }
}

export default SaeGalleryItem;
