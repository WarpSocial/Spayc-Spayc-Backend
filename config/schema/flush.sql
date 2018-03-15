-- event+room reference
DELETE FROM event_auth;
-- event+room reference
DELETE FROM event_edges;
-- event+room reference
DELETE FROM event_forward_extremities;
-- event+room+room metadata reference
DELETE FROM event_json;
-- event+hash id reference
DELETE FROM event_reference_hashes;
-- event reference
DELETE FROM event_search;
-- event reference
DELETE FROM event_to_state_groups;
-- event+room reference
DELETE FROM events;
-- event+room reference
DELETE FROM guest_access;
-- event+room reference
DELETE FROM history_visibility;
-- event+room+invite reference
DELETE FROM local_invites;
-- media files reference
DELETE FROM local_media_repository;
-- media files reference
DELETE FROM local_media_repository_thumbnails;
-- user reference
DELETE FROM presence_stream;
-- user reference
DELETE FROM profiles;
-- room reference
DELETE FROM public_room_list_stream;
