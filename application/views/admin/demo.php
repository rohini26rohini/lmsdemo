<div class="content">
<form action="/admin/config/development/generate/content" method="post" id="devel-generate-content-form" accept-charset="UTF-8">
<div>
<table class="sticky-enabled">
    <thead>
        <tr>
            <th class="select-all"></th>
            <th>Content type</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        <tr class="odd">
            <td>
                <div class="form-item form-type-checkbox form-item-node-types-forum">
                    <input type="checkbox" id="edit-node-types-forum" name="node_types[forum]"
                    value="forum" class="form-checkbox" />
                </div>
            </td>
            <td>Forum topic</td>
            <td><small>Open</small>
            </td>
        </tr>
        <tr class="even">
            <td>
                <div class="form-item form-type-checkbox form-item-node-types-article">
                    <input type="checkbox" id="edit-node-types-article" name="node_types[article]"
                    value="article" class="form-checkbox" />
                </div>
            </td>
            <td>Article</td>
            <td><small>Open</small>
            </td>
        </tr>
        <tr class="odd">
            <td>
                <div class="form-item form-type-checkbox form-item-node-types-page">
                    <input type="checkbox" id="edit-node-types-page" name="node_types[page]"
                    value="page" class="form-checkbox" />
                </div>
            </td>
            <td>Basic page</td>
            <td><small>Hidden</small>
            </td>
        </tr>
        <tr class="even">
            <td>
                <div class="form-item form-type-checkbox form-item-node-types-test-content-type">
                    <input type="checkbox" id="edit-node-types-test-content-type" name="node_types[test_content_type]"
                    value="test_content_type" class="form-checkbox" />
                </div>
            </td>
            <td>Test content type</td>
            <td><small>Closed</small>
            </td>
        </tr>
        <tr class="odd">
            <td>
                <div class="form-item form-type-checkbox form-item-node-types-webform">
                    <input type="checkbox" id="edit-node-types-webform" name="node_types[webform]"
                    value="webform" class="form-checkbox" />
                </div>
            </td>
            <td>Webform</td>
            <td><small>Open</small>
            </td>
        </tr>
    </tbody>
</table>
</div>

            
    <div class="count-checkboxes-wrapper">
        <span id="count-checked-checkboxes">0</span> checked
    </div>
            
    
    <div class="form-item form-type-textfield form-item-count-checked-checkboxes">
      <label for="edit-count-checked-checkboxes">count-checked-checkboxes <span class="form-required" title="Szükséges mező.">*</span></label>
     <input type="text" id="edit-count-checked-checkboxes" name="count-checked-checkboxes" value="0" size="60" maxlength="50" class="form-text required" />
    </div>    

</form>
</div>

<script>
$(document).ready(function(){

var $checkboxes = $('#devel-generate-content-form td input[type="checkbox"]');
    
$checkboxes.change(function(){
    var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
    $('#count-checked-checkboxes').text(countCheckedCheckboxes);
    
    $('#edit-count-checked-checkboxes').val(countCheckedCheckboxes);
});

});
</script>
