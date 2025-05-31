package com.zaleort.second_brain.Tags.Domain.Tag

import com.zaleort.second_brain.Shared.Domain.QueryFilter.PaginatedResult
import com.zaleort.second_brain.Users.Domain.User.UserId

interface TagRepositoryInterface {
    fun findById(tagId: TagId): Tag?
    fun findByUserId(userId: UserId): List<Tag>
    fun save(tag: Tag)
    fun delete(tagId: TagId)
    fun search(params: TagSearchParams): PaginatedResult<Tag>
}