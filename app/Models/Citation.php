<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citation extends Model
{
	protected $table = "citations.citations";
	protected $primaryKey = "citation_id";
	public $incrementing = false;

	protected $fillable = [
		'citation_id',
		'citation_type',
		'collaborators',
		'citation_text',
		'note'
	];

	protected $hidden = ['id', 'citation_type', 'created_at', 'updated_at'];
	protected $appends = ['type'];

	public function metadata() {
		return $this->hasOne('App\CitationMetadata', 'citation_id');
	}

	public function type() {
		return $this->hasOne('App\CitationType', 'citation_type', 'citation_type');
	}

	public function collection() {
		return $this->hasOne('App\Collection', 'citation_id');
	}

	public function document() {
		return $this->hasOne('App\Document', 'citation_id');
	}

	public function publishedMetadata() {
		return $this->hasOne('App\PublishedMetadata', 'citation_id');
	}

	public function publisher() {
		return $this->hasOne('App\Publisher', 'citation_id');
	}

	public function members() {
		return $this->belongsToMany('App\User', 'nemo.memberships', 'parent_entities_id', 'individuals_id')
			->withPivot('role_position')
			->withPivot('precedence');
	}

	/**
	 * Renders the citation_type attribute as an attribute called "type".
	 *
	 * @return string
	 */
	public function getTypeAttribute() {
		return $this->citation_type;
	}

	/**
	 * Query scope to filter records by the citation ID and without having
	 * to prepend the "citations:" collection manually.
	 *
	 * @param int $id The ID of the citation
	 * @return Builder
	 */
	public function scopeWherePartialId($query, $id) {
		return $query->where("citation_id", "citations:{$id}");
	}
}