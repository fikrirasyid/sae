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
   * @since 0.1
   *
   * @return array
   */
  static css(props) {
    let additionalCss = [];

    // Selectors
    const galleryWrapperSelector = '%%order_class%% .sae-gallery-wrapper';
    const galleryItemSelector    = '%%order_class%% .sae_gallery_item';
    const galleryCaptionSelector = '%%order_class%% .sae-gallery-item-caption';

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

    // Grid layout style
    if ('grid' === props.layout) {
      // Gallery - Column width
      additionalCss = additionalCss.concat(saeUtils.generateCss(
        props,
        'column_flex_grid',
        'column',
        galleryItemSelector,
        'width',
        false
      ));

      if ('index' === props.caption_position) {
        additionalCss = additionalCss.concat(saeUtils.generateCss(
          props,
          'column_flex_grid',
          'column',
          '%%order_class%% .sae-gallery-item-caption--index',
          'width',
          false
        ));
      }
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

    // GALLERY ITEM - Margin
    additionalCss = additionalCss.concat(saeUtils.generateCss(
      props,
      'margin',
      'item',
      galleryItemSelector,
      '',
      false
    ));

    // GALLERY ITEM - Padding
    additionalCss = additionalCss.concat(saeUtils.generateCss(
      props,
      'padding',
      'item',
      galleryItemSelector,
      '',
      false
    ));

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
   * Render table of content caption
   *
   * @since 0.2
   */
  renderTableOfContentCaptions() {
    if ('index' !== this.props.caption_position) {
      return false;
    }

    const tableOfContentItem = this.props.content.map(item => {
      return (<li
        className='sae-gallery-gallery-caption-list--item'
        key={`sae-gallery-caption-index-${item.props.address}`}
      >{item.props.attrs.caption}</li>);
    });

    return <div className='sae-gallery-item-caption sae-gallery-item-caption--index'>
      <ol className='sae-gallery-item-caption-list'>
        {tableOfContentItem}
      </ol>
    </div>;
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
      `sae-gallery-wrapper--caption-${this.props.caption_position}`,
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
        {this.renderTableOfContentCaptions()}
      </div>
    );
  }
}

export default SaeGallery;
