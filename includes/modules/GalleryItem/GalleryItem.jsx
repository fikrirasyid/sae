// External Dependencies
import React, { Component } from 'react';


class SaeGalleryItem extends Component {

  static slug = 'sae_gallery_item';

  /**
   * Module render in VB
   */
  render() {
    return (
      <div className="sae-gallery-item-wrapper">
        <img src={this.props.src} alt={this.props.title} />
        <h4 className="sae-gallery-item-title">{this.props.title}</h4>
        <div className="sae-gallery-item-description">{this.props.content()}</div>
      </div>
    );
  }
}

export default SaeGalleryItem;
