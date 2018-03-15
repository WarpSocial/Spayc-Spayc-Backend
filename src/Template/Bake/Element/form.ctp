<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}
%>
<div class="<%= $pluralVar %> form">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('<%= Inflector::humanize($action) %> <%= $singularHumanName %>') ?>
            <div class="pull-right rtbutton">
                <% if (strpos($action, 'add') === false): %>
                <?= $this->Form->postLink('<span class="fa fa-times"></span>&nbsp;&nbsp;Delete',['action' => 'delete', $<%= $singularVar %>-><%= $primaryKey[0] %>],['class'=>'btn btn-danger','escape' => false,'confirm' => __('Are you sure you want to delete # {0}?', $<%= $singularVar %>-><%= $primaryKey[0] %>)]) ?>
                <% endif; %>
                &nbsp;&nbsp;<?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?>        
                        
           </div>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
    <?= $this->Form->create($<%= $singularVar %>,['role' => 'form']) ?>
        <?php
<%
        foreach ($fields as $field) {
            if (in_array($field, $primaryKey)) {
                continue;
            }
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
%>
            echo '<div class="form-group">';
            echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>],['empty' => true,'class' => 'form-control', 'placeholder' => '<%= Inflector::humanize($field) %>']);
            echo '</div>';
<%
                } else {
%>
            echo '<div class="form-group">';        
            echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>],['class' => 'form-control', 'placeholder' => '<%= Inflector::humanize($field) %>']);
            echo '</div>';
<%
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {
                $fieldData = $schema->column($field);
                if (in_array($fieldData['type'], ['date', 'datetime', 'time']) && (!empty($fieldData['null']))) {
%>
            echo '<div class="form-group">';        
            echo $this->Form->input('<%= $field %>', ['empty' => true],['class' => 'form-control', 'placeholder' => '<%= Inflector::humanize($field) %>']);
            echo '</div>';
<%
                } else {
%>
            echo '<div class="form-group">';        
            echo $this->Form->input('<%= $field %>',['class' => 'form-control', 'placeholder' => '<%= Inflector::humanize($field) %>']);
            echo '</div>';
<%
                }
            }
        }
        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
            echo '<div class="form-group">';    
            echo $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>,'class' => 'form-control', 'placeholder' => '<%= Inflector::humanize($field) %>']);
            echo '</div>';
<%
            }
        }
%>
        ?>
   <?php echo  '<div class="form-group">'; ?>
    <?= $this->Form->button(__('Submit'),['class' => 'btn btn-info']) ?>
    <?= $this->Form->end() ?>
    <?php echo '</div>'; ?>
</div>
        </div>
    </div>
</div>
