package com.zaleort.second_brain.Tags.Infrastructure.Repository

import org.springframework.data.jpa.repository.JpaRepository
import org.springframework.data.jpa.repository.JpaSpecificationExecutor
import java.util.*

interface JpaTagRepository : JpaRepository<TagEntity, UUID>, JpaSpecificationExecutor<TagEntity> {
    fun findByUserId(userId: UUID): List<TagEntity>
}