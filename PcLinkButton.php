<?php
Yii::import('zii.widgets.grid.CGridColumn');

/**
 * PcLinkButton.php
 * Created on 29 05 2012 (2:11 PM)
 *
 * @license:
 * Copyright (c) 2012, Boaz Rymland
 * All rights reserved.
 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the
 * following conditions are met:
 * - Redistributions of source code must retain the above copyright notice, this list of conditions and the following
 *      disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following
 *      disclaimer in the documentation and/or other materials provided with the distribution.
 * - The names of the contributors may not be used to endorse or promote products derived from this software without
 *      specific prior written permission.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR
 * TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */
class PcLinkButton extends CGridColumn {
	/**
	 * @var string the label to the hyperlinks in the data cells. Note that the label will not
	 * be HTML-encoded when rendering. This property is ignored if {@link labelExpression} is set.
	 * @see labelExpression
	 */
	public $label = 'Link';
	/**
	 * @var string a PHP expression that will be evaluated for every data cell and whose result will be rendered
	 * as the label of the hyperlink of the data cells. In this expression, the variable
	 * <code>$row</code> the row number (zero-based); <code>$data</code> the data model for the row;
	 * and <code>$this</code> the column object.
	 */
	public $labelExpression;
	/**
	 * @var string the URL to the image. If this is set, an image link will be rendered.
	 */
	public $imageUrl;

	/**
	 * @var string. PHP code snippet that would dynamically be evaluated and should outcome the image url based
	 * on current $data and $row in context
	 */
	public $imageUrlExpression;
	/**
	 * @var string the URL of the hyperlinks in the data cells.
	 * This property is ignored if {@link urlExpression} is set.
	 * @see urlExpression
	 */
	public $url = 'javascript:void(0)';
	/**
	 * @var string a PHP expression that will be evaluated for every data cell and whose result will be rendered
	 * as the URL of the hyperlink of the data cells. In this expression, the variable
	 * <code>$row</code> the row number (zero-based); <code>$data</code> the data model for the row;
	 * and <code>$this</code> the column object.
	 */
	public $urlExpression;
	/**
	 * @var array the HTML options for the data cell tags.
	 */
	public $htmlOptions = array('class' => 'link-column');
	/**
	 * @var array the HTML options for the header cell tag.
	 */
	public $headerHtmlOptions = array('class' => 'link-column');
	/**
	 * @var array the HTML options for the footer cell tag.
	 */
	public $footerHtmlOptions = array('class' => 'link-column');
	/**
	 * @var array the HTML options for the hyperlinks
	 */
	public $linkHtmlOptions = array();

	/**
	 * @var boolean whether the column is sortable. If so, the header cell will contain a link that may trigger the sorting.
	 * Defaults to true. Note that if 'name' is not set, or if 'name' is not allowed by 'CSort', this property will be
	 * treated as false.
	 * @see name
	 */
	public $sortable = true;

	/**
	 * @var string the attribute name of the data model. Used for column sorting, filtering and to render the corresponding
	 * attribute value in each data cell.
	 * @see sortable
	 */
	public $name;

	/**
	 * Renders the data cell content.
	 * This method renders a hyperlink in the data cell.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data associated with the row
	 */
	protected function renderDataCellContent($row, $data) {
		if ($this->urlExpression !== null)
			$url = $this->evaluateExpression($this->urlExpression, array('data' => $data, 'row' => $row));
		else
			$url = $this->url;
		if ($this->labelExpression !== null)
			$label = $this->evaluateExpression($this->labelExpression, array('data' => $data, 'row' => $row));
		else
			$label = $this->label;
		if ($this->imageUrlExpression) {
			$imageUrl = $this->evaluateExpression($this->imageUrlExpression, array('data' => $data, 'row' => $row));
		}
		else {
			$imageUrl = $this->imageUrl;
		}
		$options = $this->linkHtmlOptions;
		if (is_string($imageUrl)) {
			echo CHtml::link(CHtml::image($imageUrl, $label), $url, $options);
		}
		else {
			echo CHtml::link($label, $url, $options);
		}
	}

	/**
	 * Renders the header cell content.
	 * This method will render a link that can trigger the sorting if the column is sortable.
	 */
	protected function renderHeaderCellContent() {
		if ($this->grid->enableSorting && $this->sortable && $this->name !== null) {
			echo $this->grid->dataProvider->getSort()->link($this->name, $this->header);
		}
		else if ($this->name !== null && $this->header === null) {
			if ($this->grid->dataProvider instanceof CActiveDataProvider) {
				echo CHtml::encode($this->grid->dataProvider->model->getAttributeLabel($this->name));
			}
			else {
				echo CHtml::encode($this->name);
			}

		}

		else {
			parent::renderHeaderCellContent();
		}
	}
}