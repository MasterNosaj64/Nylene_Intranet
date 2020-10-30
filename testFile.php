<html>
<?php 


$provider = new DbTableDataProvider($pdoConnection, 'my_table');
$input = new InputSource($_GET);

// create grid
$grid = new Grid(
$provider,
// all components are optional, you can specify only columns
[
new TableCaption('My Grid'),
new Column('id'),
new Column('name'),
new Column('role'),
new Column('birthday'),
(new Column('age'))
->setValueCalculator(function ($row) {
    return DateTime
    ::createFromFormat('Y-m-d', $row->birthday)
    ->diff(new DateTime('now'))
    ->y;
})
->setValueFormatter(function ($val) {
    return "$val years";
})
,
new DetailsRow(new SymfonyVarDump()), // when clicking on data rows, details will be shown
new PaginationControl($input->option('page', 1), 5), // 1 - default page, 5 -- page size
new PageSizeSelectControl($input->option('page_size', 5), [2, 5, 10]), // allows to select page size
new ColumnSortingControl('id', $input->option('sort')),
new ColumnSortingControl('birthday', $input->option('sort')),
new FilterControl('name', FilterOperation::OPERATOR_LIKE, $input->option('name')),
new CsvExport($input->option('csv')), // yep, that's so simple, you have CSV export now
new PageTotalsRow([
    'id' => PageTotalsRow::OPERATION_IGNORE,
    'age' => PageTotalsRow::OPERATION_AVG
])
]
);

// now you can render it:
echo $grid->render();
// or even this way:
echo $grid;

//  but also you can add some styling:
$customization = new BootstrapStyling();
$customization->apply($grid);
echo $grid;


?>





</html>	