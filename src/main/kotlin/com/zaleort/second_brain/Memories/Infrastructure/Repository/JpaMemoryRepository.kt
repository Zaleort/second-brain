package com.zaleort.second_brain.Memories.Infrastructure.Repository

import org.springframework.data.jpa.repository.JpaRepository
import org.springframework.data.jpa.repository.JpaSpecificationExecutor
import java.util.*

interface JpaMemoryRepository : JpaRepository<MemoryEntity, UUID>, JpaSpecificationExecutor<MemoryEntity> {
    fun findByUserId(userId: UUID): List<MemoryEntity>
}