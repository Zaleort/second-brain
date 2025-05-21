package com.zaleort.second_brain.Tags.Infrastructure.Repository

import org.springframework.data.jpa.repository.JpaRepository
import java.util.UUID

interface JpaTagRepository : JpaRepository<TagEntity, UUID> {
    fun findByUserId(userId: UUID): List<TagEntity>
}