// External Dependencies
import React, { Component } from 'react';

class SaeGallery extends Component {

  static slug = 'sae_gallery';

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
