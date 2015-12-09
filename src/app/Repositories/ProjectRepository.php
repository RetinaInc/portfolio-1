<?php namespace DanPowell\Portfolio\Repositories;

/*
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
*/

// Load up the models
use DanPowell\Portfolio\Models\Project;
use DanPowell\Portfolio\Models\Tag;

/**
 * A handy repo for doing common RESTful based things like indexing, saving etc.
 */
class ProjectRepository
{



    // Get all Projects
    public function getAllProjects($with = [], $order = null, $by = 'DESC')
	{
        // Get all the projects
        $projects = Project::with($with);

    	if ($order) {
    	    $projects->orderBy($order, $by);
    	}

    	return $projects->get();
    }

    // Get all Tags
    public function getAllTags($with = [], $order = null, $by = 'DESC')
	{
        // Get all the tags
        $tags = Tag::with($with);

        if ($order) {
            $tags->orderBy($order, $by);
        }

        return $tags->get();
    }



    // Loop through all of the projects and concatenate the tags together as a single string - keeps the template clean
    public function addAllTagstoCollection($items)
	{
        foreach($items as $item) {
            $item->allTags = $this->collateTagsAsString($item);
    	}
        return $items;
	}

    // Get all tags & filter so only those related to project are returned
    public function filterProjectTagsWithRelationship($tags, $related = null)
    {

    	// We only need tags that have a relationship with a project
        // Use Eloquent's filter method, allowing only tags with relationships to Projects are be returned
        $tags = $tags->filter(function($tag) use ($related)
        {
            if(isset($tag->$related) && count($tag->$related) > 0) {
        	    return $tag;
        	}
        });

        return $tags;
    }


    // Get all project tags as string
    private function collateTagsAsString($item)
    {
    	$tags = '';
        foreach($item->tags as $tag){
    	    $tags .= '-' . str_slug($tag->title) . ' ';
        }
        return $tags;
    }

}