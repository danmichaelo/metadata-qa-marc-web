{* Additional Dewey Decimal Classification Number
   http://www.loc.gov/marc/bibliographic/bd083.html *}
{assign var="fieldInstances" value=getFields($record, '083')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>additional DDC</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="083">
      {*  Classification number *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="Classification number"></i>
        <a href="#" class="record-link" data="083a_ClassificationAdditionalDdc_ss" title="Classification number">{$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->c)}
        <a href="#" class="subdivision" data="083c" title="Classification number--Ending number of span">{$field->subfields->c}</a>
      {/if}

      {if isset($field->subfields->m)}
        <span class="designation" data="083m"
              title="Standard or optional designation">{$field->subfields->m}</span>
      {/if}

      {if isset($field->subfields->q)}
        <span class="agency" data="083q_ClassificationAdditionalDdc_source_ss"
              title="Assigning agency">{$field->subfields->q}</span>
      {/if}

      {if isset($field->subfields->y)}
        <span class="table-sequence-number" data="083y"
              title="Table sequence number for internal subarrangement or add table">{$field->subfields->y}</span>
      {/if}

      {if isset($field->subfields->z)}
        <span class="table-id" data="083z"
              title="Table identification">{$field->subfields->z}</span>
      {/if}

      {if isset($field->subfields->{'2'})}
        <a href="#" class="source" data="0832_ClassificationAdditionalDdc_edition_ss" title="Source">{$field->subfields->{'2'}}</a>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
