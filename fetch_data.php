<?php
require_once 'config/db.php';

// Fetch home content
$result = $db->query("SELECT * FROM home ORDER BY created_at DESC");
$contents = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['framework'] = json_decode($row['framework'], true);
        $contents[] = $row;
    }
}

// Fetch partners
$partners_result = $db->query("SELECT * FROM partners ORDER BY created_at DESC");
$partners = [];
if ($partners_result) {
    while ($row = $partners_result->fetch_assoc()) {
        $partners[] = $row;
    }
}

// Fetch about content
$about_result = $db->query("SELECT * FROM about ORDER BY created_at DESC");
$about_content = null;
if ($about_result && $about_result->num_rows > 0) {
    $about_content = $about_result->fetch_assoc();
    $about_content['metrics'] = json_decode($about_content['metrics'], true);
}

// Fetch timeline content
$timeline_result = $db->query("SELECT * FROM timeline ORDER BY created_at ASC");
$timelines = [];
if ($timeline_result) {
    while ($row = $timeline_result->fetch_assoc()) {
        $timelines[] = $row;
    }
}

// Fetch works content
$works_result = $db->query("SELECT * FROM works ORDER BY created_at DESC");
$works = [];
if ($works_result) {
    while ($row = $works_result->fetch_assoc()) {
        $works[] = $row;
    }
}

// Fetch projects content
$projects_result = $db->query("SELECT * FROM projects ORDER BY created_at DESC LIMIT 3");
$projects = [];
if ($projects_result) {
    while ($row = $projects_result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// Fetch inspiration content
$inspiration_result = $db->query("SELECT * FROM inspiration ORDER BY created_at DESC");
$inspirations = [];
if ($inspiration_result) {
    while ($row = $inspiration_result->fetch_assoc()) {
        $inspirations[] = $row;
    }
}

// Fetch testimonials
$testimonials_result = $db->query("SELECT * FROM testimonials ORDER BY created_at DESC");
$testimonials = [];
if ($testimonials_result) {
    while ($row = $testimonials_result->fetch_assoc()) {
        $row['logo_url'] = 'dashboard/' . $row['image'];
        $testimonials[] = $row;
    }
}

// Get unique statuses for filter
$statuses = array_unique(array_column($timelines, 'status'));

// Get selected status from URL parameter
$selected_status = isset($_GET['status']) ? $_GET['status'] : 'all';