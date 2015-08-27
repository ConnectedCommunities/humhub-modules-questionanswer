<?php

/**
 * This is the model class for table "tag".
 *
 * The followings are the available columns in table 'tag':
 * @property integer $id
 * @property string $tag
 * @property string $description
 */
class Tag extends HActiveRecordContentContainer implements ISearchable
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tag';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tag', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tag, description', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tag' => 'Tag',
			'description' => 'Description',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tag',$this->tag,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/** 
	 * Find and return the first tag that matches 
	 * If it cannot find a match, create the tag
	 * @param  String  $tag
	 */
	public function firstOrCreate($tag) 
	{

		$foundTag = Tag::model()->find('tag=:tag', array(':tag'=>$tag));

		if($foundTag) { // found tag
			return $foundTag;
		} else {
			$tagModel = new Tag;
			$tagModel->tag = $tag;
			$tagModel->save();
			return $tagModel;
		}

	}


    /**
     * Returns URL to the Question
     *
     * @param array $parameters
     * @return string
     */
    public function getUrl($parameters = array())
    {
    	return $this->createUrl('//questionanswer/main/tag', $parameters);
    }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tag the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     * After Save Addons
     *
     * @return type
     */
    protected function afterSave()
    {
        HSearch::getInstance()->addModel($this);
        return parent::afterSave();
    }


    /**
     * Returns an array of informations used by search subsystem.
     * Function is defined in interface ISearchable
     *
     * @return Array
     */
    public function getSearchAttributes()
    {

        $attributes = array(

        	// Assignments
            'belongsToType' => 'Tag',
            'belongsToId' => $this->id,
            'belongsToGuid' => null,

            // Information about the record
            'model' => 'Tag',
            'pk' => $this->id,
            'title' => $this->tag,
            'url' => $this->getUrl(array('id' => $this->id)),

            // Extra indexed fields
            'post_text' => $this->tag
        );


        return $attributes;
    }

    /**
     * Returns the Search Result Output
     */
    public function getSearchResult()
    {
        return Yii::app()->getController()->widget('application.modules.questionanswer.widgets.TagSearchResultWidget', array('tag' => $this), true);
    }
}
