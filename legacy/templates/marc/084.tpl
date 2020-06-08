{* Other Classificaton Number
   http://www.loc.gov/marc/bibliographic/bd084.html *}
{assign var="fieldInstances" value=getFields($record, '084')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>other classifications</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="084">
      {*  Classification number *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="Classification number"></i>
        <a href="#" class="record-link" data="084a_Classification_classificationPortion_ss" title="Classification number">{$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->b)}
        <a href="#" class="subdivision" data="084b"
           title="Item number">{$field->subfields->b}</a>
      {/if}

      {if isset($field->subfields->q)}
        <span class="agency" data="084q_Classification_assigner_ss"
              title="Assigning agency">{$field->subfields->q}</span>
      {/if}

      {if isset($field->subfields->{'2'})}
        <a href="#" class="source" data="0842_Classification_source_ss" title="Source">{$field->subfields->{'2'}}</a>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
