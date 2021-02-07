<div class="alert  ">
<button class="close" data-dismiss="alert"></button>
Question: Advanced Input Field</div>

<p>
1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.

</p>


<p>
2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field

<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>



<div class="alert alert-success">
<button class="close" data-dismiss="alert"></button>
The table you start with</div>

<table id="rich-input-form" class="table table-striped table-bordered table-hover ">
<thead>
<th><span id="add_item_button" class="btn mini green" onclick="addToObj=false">
											<i class="icon-plus"></i></span></th>
<th>Description</th>
<th>Quantity</th>
<th>Unit Price</th>
</thead>

<tbody>
	<tr>
        <td><span class="btn mini deletebutton"><i class="icon-remove"></i></span></td>
        <td class="masked-input"><p data-input-type="textarea" name="data[1][description]" class="wrap description"></p></td>
        <td class="masked-input"><p data-input-type="input" name="data[1][quantity]" class="right-align"></p></td>
        <td class="masked-input"><p data-input-type="input" name="data[1][unit_price]" class="right-align"></p></td>
    </tr>
</tbody>

</table>


<p></p>
<div class="alert alert-info ">
<button class="close" data-dismiss="alert"></button>
Video Instruction</div>

<p style="text-align:left;">
<video width="78%"   controls>
  <source src="<?php echo Router::url("/video/q3_2.mov") ?>">
Your browser does not support the video tag.
</video>
</p>

<style>
    textarea {
        width: 90%;
    }

    .right-align {
        text-align: right;
    }
</style>

<?php $this->start('script_own');?>
<script>

var RichInputForm = {
    counter: 1,
    container: null, 
    rowTemplate: null,

    initialize: function(id) {
        this.container = $('#' + id)
        this.initializeRowTemplate();
        this.activateFormEvents()
    },

    initializeRowTemplate: function(){
        row = this.container.children('tbody').children('tr:first');
        row.children().each(function() {
            if ($(this).children('p:first').data('name') !== null) {
                namePlaceholder = $(this).children('p:first').attr('name').replace(/[0-9]+/g, ":rowNumber")
                $(this).children('p:first').attr('name', namePlaceholder);
            }
        })

        this.rowTemplate = row[0].outerHTML;
    },

    addNewRow: function() {
        this.counter += 1;

        newRow = this.rowTemplate.replace(':rowNumber', this.counter);
        this.container.children('tbody').append(newRow);
    },

    removeRow: function(element) {
        element.closest('tr').remove()
    },

    convertToPtag: function(element) {

        if (element.prop('tagName') === 'P') {
            return;
        }

        props = element[0].attributes;

        newInput = $('<p></p>');

        $.each(props, function(index, value){
            newInput.attr(value['localName'], value['value']);
        });

        newInput.text(element.val());
        
        element.replaceWith(newInput);
    },

    convertToInput: function(element) {

        if (element.length === 0) {
            return;
        }

        props = element[0].attributes;

        inputType = element.data("input-type");

        switch(inputType) {
            case "textarea":
                newElement = '<textarea type="text" rows="4"></textarea>';
                break;
            default:
                newElement = '<input></input>'
        }

        newInput = $(newElement);

        $.each(props, function(index, value){
            newInput.attr(value['localName'], value['value']);
        });
        
        newInput.val(element.text());
        element.replaceWith(newInput);
    },

    activateFormEvents: function() {
        self = this;

        $("#add_item_button").click(function(event, instance){
            self.addNewRow()
        });
        
        $('.deletebutton').live('click', function(instance) {
            self.removeRow($(this)[0])
        });

        $(".masked-input").live('click', function(instance){
            self.convertToInput($(this).children('p:first'));
        });

        $(".masked-input").live('mouseleave', function(instance){
            self.convertToPtag($(this).children().first());
        });
    }
}

$(document).ready(function(){
    form = RichInputForm
    form.initialize('rich-input-form')
});
</script>
<?php $this->end();?>
