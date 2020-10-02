---
title: "{{ $post->title }}"
description: "{{ collect($post->ingredients['sentences'])->shuffle()->random() }}"
date: "{{ $post->published_at->format('Y-m-d') }}"
categories:
  - "{{ $post->category }}"
images: 
  - "{{ collect($post->ingredients['images'])->shuffle()->random()['image'] }}"
featuredImage: "{{ collect($post->ingredients['images'])->shuffle()->random()['image'] }}"
featured_image: "{{ collect($post->ingredients['images'])->shuffle()->random()['image'] }}"
image: "{{ collect($post->ingredients['images'])->shuffle()->random()['image'] }}"
---

{!! $post->content !!}