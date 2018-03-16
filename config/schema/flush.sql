-- user+device id reference
DELETE FROM access_tokens;
-- user+content reference
DELETE FROM account_data;
-- user+room reference
DELETE FROM blocked_rooms;
-- cache validation function reference
DELETE FROM cache_invalidation_stream;
-- room+stream+event reference
DELETE FROM current_state_delta_stream;
-- room+event reference
DELETE FROM current_state_events;
-- user+device cache reference
DELETE FROM device_lists_remote_cache;
-- user+stream reference
DELETE FROM device_lists_remote_extremeties;
-- user+device reference
DELETE FROM device_lists_stream;
-- user+device reference
DELETE FROM devices;
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
-- room alias reference
DELETE FROM room_alias_servers;
-- room alias reference
DELETE FROM room_aliases;
-- room reference
DELETE FROM room_depth;
-- room reference
DELETE FROM room_hosts;
-- room+event+user reference
DELETE FROM room_memberships;
-- room reference
DELETE FROM room_names;
-- room reference
DELETE FROM room_tags;
-- room+user reference
DELETE FROM room_tags;
-- room reference
DELETE FROM rooms;
-- room+event reference
DELETE FROM state_events;
-- room+event reference
DELETE FROM state_forward_extremities;
-- room+event reference
DELETE FROM state_groups;
-- room+group reference
DELETE FROM state_group_edges;
-- room+group reference
DELETE FROM state_groups_state;
-- room reference
DELETE FROM stream_ordering_to_exterm;
-- room+event reference
DELETE FROM topics;
-- room+user reference
DELETE FROM user_directory;
-- user reference
DELETE FROM user_directory_search;
-- user reference
DELETE FROM user_ips;
-- user reference
DELETE FROM users;
-- user+room reference
DELETE FROM users_in_public_rooms;
-- user reference
DELETE FROM users_who_share_rooms;