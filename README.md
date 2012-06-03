PcLinkButton
============

Yii extension: Provides a 'grid column' with dynamic image url evaluation, useful in CGridView with objects that have click-able image icon

## Description

This extension enables rendering a 'dynamic' image per row object in a grid view. The class provided by this extension, PcLinkButton, is a brother class to other *Column classes - CDataColumn, CLinkColumn, CButtonColumn and CCheckBoxColumn. 
What it provides is similar to the way "urlExpression" and "labelExpression" are evaluated in CLinkColumn: an ability to render "imageUrlExpression" per data object being rendered.

## Requirements

Not many I guess. Tested on Yii v1.1.10.

## Usage

- Extract the contents of this extension and put PcLinkButton.php in your /protected/components directory.
- In your grid view rendering, do something similar to:

```php
$this->widget('zii.widgets.grid.CGridView', array(
  'id' => 'my-id',
  'dataProvider' => $model->search(),
  'filter' => $model,
  'columns' => array(
    //... more columns
    array(
      'class' => 'PcLinkButton',
      'imageUrlExpression' => 'SomeModel::getWebPath($some_param) . basename($data->category->icon_filename)',
      'urlExpression' => '"/pathTo/" . strtolower($data->name)',
      'labelExpression' => '$data->name',
      'header' => "Column Title,
  ),,
));
```


## Resources

