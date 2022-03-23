if (params._source.containsKey('post_type')) {
    return params[params._source['post_type']] * _score;
} else { 
    return _score;
}

